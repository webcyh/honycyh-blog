<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-24 16:10:57
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-02-25 08:26:47
 */

/**
 * 意图：
 * 对于项目整个执行过程当中可能任何地方都需要用到的类的实例
 * 为了方便管理 所以将他们挂载到注册树上面
 */

namespace Core;
/**
 * register
 */
class Register
{
    //相关的类映射的类
    protected static $alias = [];

    public static function _get($className)
    {
        if (!isset(self::$alias[$className])) {
            self::$alias[$className] = new $className();
            //注意这里是完成的类名 包括命名空间
        }
        return self::$alias[$className];
    }

    public static function _unset($className)
    {

        unset(self::$alias[$className]);

    }

    public function _getAlias()
    {
        return self::$alias;
    }
}
