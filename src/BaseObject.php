<?php

namespace Qiyewechat;


class BaseObject extends \yii\base\BaseObject
{

    private static $_instance = null;
    /**
     * 获取实例
     *
     * @param array $config
     *
     * @return mixed|null|$this
     */
    public static function getInstance($config = [])
    {
        $className = get_called_class();
        $key       = md5($className);
        if (empty(self::$_instance[$key])) {
            self::$_instance[$key] = new $className($config);
        }
        return self::$_instance[$key];
    }

}
