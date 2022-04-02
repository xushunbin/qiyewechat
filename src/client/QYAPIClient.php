<?php

namespace Qiyewechat\client;

/**
 * 客户端
 */
class QYAPIClient extends \Qiyewechat\http\Client
{
    /**
     * 接口请求的host
     *
     * @var string
     */
    protected $host = 'https://qyapi.weixin.qq.com';

    /**
     * 接口请求的端口号
     *
     * @var string
     */
    protected $port = '';

}
