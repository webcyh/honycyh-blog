<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-23 10:28:39
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-02-23 10:29:11
 */

namespace decorator;
/**
 * 转换为json格式数据
 */
class general
{
    public function beforeRequest($controller)
    {

    }

    public function afterRequest($data = [])
    {
        p($data);
    }
}
