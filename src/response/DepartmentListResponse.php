<?php

namespace Qiyewechat\response;

class DepartmentListResponse extends Response
{

    /**
     * @var []Department $department
     */
    public array $department;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->department = [];
        foreach ($config['department'] ?? [] as $k => $v) {
            $this->department[] = new Department($v);
        }
    }
}
