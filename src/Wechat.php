<?php

class Wechat
{
    /**
     * app key
     *
     * @var string
     */
    public $app_key;

    /**
     * 秘钥
     *
     * @var string
     */
    public $secret;


    public function getUrl()
    {
        echo $this->app_key . " / " . $this->secret . "\n";
    }

}
