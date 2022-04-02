<?php

namespace Qiyewechat\response;

use yii\base\BaseObject;

/**
 * @property $errcode
 * @property $errmsg
 */
class Response extends BaseObject
{
    /**
     * error code
     *
     * @var integer
     */
    public $errcode = null;

    /**
     * error message
     *
     * @var string
     */
    public $errmsg;

    /**
     * @return bool
     * @throws \Exception
     */
    public function isSuccess()
    {
        if ($this->errcode === null) {
            throw new \Exception('Api response error. err:' . $this->errmsg);
        }
        if ($this->errcode . '' === '0') {
            return true;
        } else {
            return false;
        }
    }

}
