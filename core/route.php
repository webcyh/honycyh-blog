<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-09 09:04:53
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 09:05:24
 */

namespace Core;
/**
 * Route
 *
 * 比如设置
 * 访问   link/:id
 * 分析为 Index/Link/12  id=12
 *
 */
class Route
{
    protected static $routes = [];

    public static function define($arr)
    {
        self::$routes = $arr;
        return true;
    }

    public static function parse($rule)
    {
        /**
         * 解析路由并且 根据参数进行匹配 转换
         */
    }

    public static function get($alias)
    {
        return isset(self::$routes[$alias]) ? self::$routes[$alias] : false;
    }
}
