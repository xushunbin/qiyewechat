<?php

namespace Qiyewechat\request;

use GuzzleHttp\RequestOptions;
use Qiyewechat\AccessToken;

class UserSimpleListRequest extends \Qiyewechat\http\Request
{

    /**
     * 获取的部门id
     *
     * @var int
     */
    public $department_id = 0;

    /**
     * 是否递归获取子部门下面的成员：1-递归获取，0-只获取本部门
     *
     * @var int
     */
    public $fetch_child = 1;


    public $method = self::GET;

    /**
     * @inheritDoc
     */
    public function getParams(): array
    {
        return [
            RequestOptions::QUERY => [
                'access_token'  => AccessToken::getInstance()->getAccessToken(),
                'department_id' => $this->department_id,
                'fetch_child'   => $this->fetch_child,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return '/cgi-bin/user/simplelist';
    }
}
