<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-21 20:23:20
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-07 00:32:13
 */

namespace decorator;
/**
 * 转换为json格式数据
 */
class json
{
    public function beforeRequest($controller)
    {
    }

    public function afterRequest($data = [])
    {
        header('content-type:text/json;');
        echo json_encode($data);
    }
}
