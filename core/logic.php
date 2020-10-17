<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-08 23:06:10
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 13:51:54
 */

namespace core;

class Logic
{
    /**
     * 动态代理类对象
     */
    private $cache = null;

    public function __construct()
    {
        //动态代理类
        // $this->cache = register::_get('\Proxy\Cache');   
    }

    /**
     * 反射
     */
    public function __call($name, $arguments)
    {
        /**
         * 反射cache代理
         * @var [type]
         */
        $ref = new \ReflectionClass($this->cache);
        if ($ref->hasMethod($name)) {
            $method = $ref->getMethod($name);
            if ($method->isPublic() && !$method->isAbstract() && count($arguments)) {
                if ($method->isStatic()) {
                    return $method->invoke(null);
                } else {
                    //这里的$arguments 是一个数组
                    return $method->invoke(
                        $this->cache,
                        $arguments
                    );
                }
            }
        }
    }
}