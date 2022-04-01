<?php

namespace Qiyewechat\http;

use BadMethodCallException;
use http\Exception\InvalidArgumentException;

abstract class Request implements RequestInterface
{
    // 请求方式
    const POST = 'POST';
    const GET = 'GET';
    const PUT = 'PUT';
    /**
     * 请求方法
     *
     * @var string
     */
    public $method = self::POST; // 默认

    /**
     * 实例化
     */
    public function __construct()
    {
        if (!in_array($this->method, [self::POST, self::GET, self::PUT])) {
            throw new BadMethodCallException('Your request method is not supported.');
        }
    }

    /**
     * 检查参数
     */
    public function checkParams()
    {
        $params = $this->getParams();
        foreach ($params as $k => $d) {
            if (!defined('GuzzleHttp\RequestOptions::' . $k)) {
                throw new InvalidArgumentException('Your parameter format error.');
            }
        }
    }

    /**
     * 接口请求之前执行
     *
     * @return bool
     */
    public function before(): bool
    {
        return true;
    }

    /**
     * 接口请求结束后执行
     *
     * @return void
     */
    public function after(array $response, $error)
    {
    }
}
