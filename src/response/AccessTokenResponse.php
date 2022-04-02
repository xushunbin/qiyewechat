<?php

namespace Qiyewechat\response;

class AccessTokenResponse extends Response
{
    /**
     * access token
     *
     * @var string
     */
    public $access_token = '';

    /**
     * 过期时间
     *
     * @var int
     */
    public $expires_in = 0;

}
