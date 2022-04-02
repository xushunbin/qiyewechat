<?php

namespace Qiyewechat\response;

class UserSimpleListResponse extends Response
{
    /**
     * @var array
     */
    public $userlist;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->userlist = [];
        foreach ($config['userlist'] ?? [] as $k => $v) {
            $this->userlist[] = new User($v);
        }
    }

}
