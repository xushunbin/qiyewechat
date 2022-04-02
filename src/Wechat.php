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
 * @property $access_token
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

    /**
     * 扫码登录后重定向地址
     *
     * @var string
     */
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
     * 获取扫码登录页面
     *
     * 在控制器中使用
     * return $this->redirect(Yii::$app->wechat->registerScanUrl('state'))
     *
     * @param string $state 参数校验放置跨站攻击
     */
    public function registerScanUrl(string $state)
    {
        if (empty($this->redirect_uri)) {
            throw new NotFoundHttpException('redirect_url required.');
        }
        return sprintf('https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid=%s&agentid=%s&redirect_uri=%s&state=%s',
            $this->corpid, $this->agentid, urlencode($this->redirect_uri), $state);
    }

    /**
     * @param string $state
     * @param string $scope snsapi_base|snsapi_userinfo|snsapi_privateinfo
     *
     * @return string
     * @deprecated
     */
    public function registerPhoneUrl(string $state, $scope = 'snsapi_privateinfo')
    {
        return sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=%s&scope=%s&state=%s#wechat_redirect',
            $this->corpid, $this->redirect_uri, 'code', 'snsapi_privateinfo', $state);
    }

    /**
     * 每一小时获取一次token
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function flushAccessTokenPerHour()
    {
        return $this->createObject(self::ACCESS_TOKEN)->getAccessToken();
    }

    const DEPARTMENT = 'department';
    const USER = 'user';
    const MESSAGE = 'message';
    const ACCESS_TOKEN = 'access_token';
    /**
     * @var []BaseObject
     */
    public $type_map = [
        self::DEPARTMENT   => Department::class,
        self::USER         => User::class,
        self::MESSAGE      => Message::class,
        self::ACCESS_TOKEN => AccessToken::class,
    ];

    /**
     * @param string $type
     *
     * @return mixed|Department|User|Message|AccessToken
     * @throws \Exception
     */
    public function createObject($type = '')
    {
        if (isset($this->type_map[$type])) {
            /**
             * @var BaseObject $baseObject
             */
            $baseObject = $this->type_map[$type];
            return $baseObject::getInstance();
        }
        throw new \Exception('Create instance failed.');
    }


}
