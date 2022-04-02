<?php

namespace Qiyewechat\response;

use yii\base\BaseObject;

/**
 *
 */
class Department extends BaseObject
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $parentid;
    /**
     * @var int
     */
    public $order;
    /**
     * @var array
     */
    public $department_leader;


}
