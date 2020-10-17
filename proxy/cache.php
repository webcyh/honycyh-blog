<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-08 22:39:38
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-08 23:41:21
 */

/**
 * 缓存代理类 在这里实现缓存的逻辑
 */

namespace proxy;

/**
 * 继承redis 实现缓存 在逻辑层调用
 */
class cache extends \core\cache\redis
{
    public function getcache($data)
    {
        $key = $data[0];
        $rst = $this->has($key);
        $rst && $rst = $this->get($key);
        $this->close();
        return $rst;
    }

    public function setcache($data)
    {
        $rst = $this->set($data[0], $data[1]);
        $this->close();
        return $rst;
    }
}