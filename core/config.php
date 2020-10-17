<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-23 19:48:32
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-05 23:50:10
 */

namespace Core;

/**
 * config
 */
class Config
{
    protected $config = [];

    public function __construct()
    {
        $this->config = require(BASE . DS . 'Config.php');
    }

    public function get($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : [];
    }
}