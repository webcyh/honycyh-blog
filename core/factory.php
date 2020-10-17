<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-20 17:14:03
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-10 15:35:25
 */

namespace Core;

/**
 * 工厂设计模式
 * 优点：将调用者和创建者进行分离 隐藏创建对象的过程方便后期维护
 * 比如说创建 一个日志类 然而创建日志的过程可能需要加载配置文件以及其他的操作
 * 当然还有可能日志我们直接new就行无需配置而是在日志类的构造函数内部进行初始化
 *
 * 当然这里可以结合注册树模式
 * 可以在创建对象之前先判断注册树上面是否存在
 */
class Factory
{
    public static function _get($class)
    {
        switch ($class) {
            case 'db':
                self::createdb();
                break;
            case 'log':
                self::createlog();
                break;
            default:

                break;
        }
    }

    public static function createlog()
    {
        /**
         * 在这里完成日志创建的过程
         *
         */
        $obj = register::_get($class);
        if ($obj) {
            return $obj;
        } else {
            $obj = new $class();
            register::_set('db', $obj);
        }
    }

    public static function createdb()
    {
        /**
         * 在这里完成数据库创建的过程
         */
    }
}