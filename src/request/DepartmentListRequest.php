<?php

namespace Qiyewechat\request;

use GuzzleHttp\RequestOptions;
use Qiyewechat\AccessToken;

class DepartmentListRequest extends \Qiyewechat\http\Request
{

    /**
     * 要获取的部门id 0 表示全部的组织架构
     *
     * @var int
     */
    public $department_id = 0;
    public $method = self::GET;

    /**
     * @inheritDoc
     */
    public function getParams(): array
    {
        return [
            RequestOptions::QUERY => [
                'access_token' => AccessToken::getInstance()->getAccessToken(),
                'id'           => $this->department_id,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return '/cgi-bin/department/list';
    }
}
