<?php

namespace Qiyewechat\http;


interface RequestInterface
{
    /**
     * 发送请求接口之前执行
     * 如果返回true继续发送 返回false结束请求
     *
     * @return bool
     */
    public function before(): bool;

    /**
     * 获取请求参数
     *
     * @return mixed
     */
    public function getParams(): array;

    /**
     * 获取接口请求路径
     *
     * @return string
     */
    public function getUri(): string;

    /**
     * 发送接口后执行
     *
     * @return mixed
     */
    public function after(array $response, $error);

}
