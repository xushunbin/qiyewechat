<?php

namespace Qiyewechat;

use Qiyewechat\client\QYAPIClient;
use Qiyewechat\request\AccessTokenRequest;
use Qiyewechat\response\AccessTokenResponse;
use Qiyewechat\response\Response;
use yii\di\Instance;
use yii\redis\Connection;

/**
 * @property Connection $redis
 */
class AccessToken extends BaseObject
{
    const ACCESS_TOKEN_KEY = 'QIYEWECHAT:ACCESS_TOKEN';

    // TODO 可设置每一个小时刷新一次token 定时任务
    /**
     * token 过期时间 7200秒 提前过期，
     *
     *
     * @var integer
     */
    const TOKEN_EXPIRE = 7100;


    /**
     * access token
     *
     * @var string
     */
    private $access_token = '';

    /**
     * redis 连接
     *
     * @var null|Connection
     */
    private $redis = null;

    /**
     * 初始化redis
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->redis = Instance::ensure('redis', Connection::class);
    }

    /**
     * 获取access token
     *
     * @return mixed|string
     */
    public function getAccessToken()
    {
        if ($this->access_token) {
            return $this->access_token;
        }
        $token = $this->redis->get(self::ACCESS_TOKEN_KEY);
        if ($token) {
            return $token;
        }
        // 缓存中没有 重新获取远程的token
        $this->getRemoteAccessToken();
        if ($this->access_token) {
            return $this->access_token;
        }
        throw new \Exception('access token error');
    }

    /**
     * 缓存token
     */
    protected function setAccessToken($accessToken)
    {
        $this->redis->setex(self::ACCESS_TOKEN_KEY, self::TOKEN_EXPIRE, $accessToken);
        $this->access_token = $accessToken;
    }

    /**
     * ```
     * [
     *   'errcode' => 0
     *   'errmsg' => 'ok'
     *   'access_token' => '7UmX5bRbnb1ffuW0F7lB0fTJs1XZm-hGCnDMRQZx2gRncitur9m3_1N7n_ohF45nWZHn7NiSxLznTbY1tuIb82jF-qtDrOyvWxtXxOceVKPlTVDRgy_-Orh08VZ8yyP4YP-GlI5bUXKm0DzS6kh1-YNXh479E6kfRtDzw7_c1Qe21RNVQgyA'
     *   'expires_in' => 7200
     * ]
     * ```
     *
     * 从远程获取access token
     */
    public function getRemoteAccessToken()
    {
        $request = new AccessTokenRequest([
            'callback' => function ($data) {
                $res = new AccessTokenResponse($data);
                if ($res->isSuccess()) {
                    // 请求成功
                    $this->setAccessToken($res->access_token);
                } else {
                    throw new \Exception('get access_token error. errMsg:' . ($data['errmsg'] ?? '上级接口请求错误'));
                }
            },
        ]);
        QYAPIClient::getInstance()->send($request);
    }

    public function __toString()
    {
        return $this->getAccessToken();
    }


}
