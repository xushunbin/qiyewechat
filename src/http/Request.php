<?php

namespace Qiyewechat\http;

use GuzzleHttp\RequestOptions;
use Qiyewechat\BaseObject;

abstract class Request extends BaseObject implements RequestInterface
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

    private $_callback = null;

    public $callback = null;

    /**
     * 实例化
     */
    public function init()
    {
        if (!in_array($this->method, [self::POST, self::GET, self::PUT])) {
            throw new \Exception('Your request method is not supported.');
        }
        if ($this->callback !== null && is_callable($this->callback)) {
            $this->_callback = $this->callback;
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
     * @param array $response
     *
     * @return array|string
     */
    public function after($response)
    {
        if (is_callable($this->_callback)) {
            call_user_func($this->_callback, $response);
        }
        return $response;
    }
}
