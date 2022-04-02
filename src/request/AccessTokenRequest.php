<?php

namespace Qiyewechat\request;

use GuzzleHttp\RequestOptions;

class AccessTokenRequest extends \Qiyewechat\http\Request
{

    /**
     * 请求方法
     *
     * @var string
     */
    public $method = self::POST;

    /**
     * @inheritDoc
     */
    public function getParams(): array
    {
        return [
            RequestOptions::JSON => [
                "corpid"     => \Yii::$app->wechat->corpid,
                "corpsecret" => \Yii::$app->wechat->corpsecret,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return '/cgi-bin/gettoken?debug=1';
    }

}
