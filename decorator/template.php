<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-21 20:23:20
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-05 17:36:06
 */

namespace decorator;
/**
 * template
 */
class template
{
    private $controller = null;

    public function beforeRequest($controller)
    {
        $this->controller = $controller;
    }

    public function afterRequest($data)
    {

        $this->controller->display($data);
    }
}
