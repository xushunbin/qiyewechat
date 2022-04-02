<?php

namespace Qiyewechat\http;

interface ClientInterface
{
    /**
     * 发送请求
     *
     * @param Request $request
     *
     * @return array|string
     */
    public function send(Request $request);

}
