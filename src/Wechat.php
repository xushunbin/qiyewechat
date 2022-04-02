<?php

namespace Qiyewechat;

use yii\base\Component;
use yii\di\Instance;
use yii\redis\Connection;
use yii\web\NotFoundHttpException;

/**
 * @property $redis
 * @property $corpid
 * @property $corpsecret
 * @property $_state
 */
class Wechat extends Component
{
    /**
     * @var Connection
     */
    protected $redis;

    /**
     * corpid 网页授权登录的appid
     *
     *
     * @var string
     * @link https://developer.work.weixin.qq.com/document/path/90665#corpid
     */
    public $corpid;

    /**
     * secret
     *
     * @var string
     * @link https://developer.work.weixin.qq.com/document/path/90665#secret
     */
    public $corpsecret;

    /**
     * 授权方的网页应用ID
     *
     * @var string
     */
    public $agentid;


    public $redirect_uri = '';

    /**
     * 携带参数
     *
     * @var string
     */
    private $_state = '';

    /**
     * 模块初始化
     *
     * 1、 启用redis
     *
     */
    public function init()
    {
        if (empty($this->corpid) || empty($this->corpsecret)) {
            throw new \Exception('corpid and corpsecret are required.');
        }
        $this->redis = Instance::ensure('redis', Connection::class);
    }

    /**
     * 设置state
     *
     * @param $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * 获取state
     *
     * @return string
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * 获取扫码登录页面
     *
     * 在控制器中使用
     * return $this->redirect(Yii::$app->wechat->registerScanUrl('state'))
     *
     * @param string $state 参数校验放置跨站攻击
     */
    public function registerScanUrl(string $state)
    {
        $this->setState($state);
        if (empty($this->redirect_uri)) {
            throw new NotFoundHttpException('redirect_url required.');
        }
        return sprintf('https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid=%s&agentid=%s&redirect_uri=%s&state=%s', $this->corpid, $this->agentid, urlencode($this->redirect_uri), $state);
    }

    /**
     * @param string $state
     * @param string $scope snsapi_base|snsapi_userinfo|snsapi_privateinfo
     *
     * @return string
     */
    public function registerPhoneUrl(string $state, $scope = 'snsapi_privateinfo')
    {
        return sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=%s&scope=%s&state=%s#wechat_redirect', $this->corpid, $this->redirect_uri, 'code', 'snsapi_privateinfo', $state);

    }

}
