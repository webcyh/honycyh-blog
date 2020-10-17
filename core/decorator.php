<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-21 20:24:16
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-02-21 20:43:44
 */

namespace Core;

use \Core\BaseController;

/**
 * baseDecorator
 */
interface Decorator
{
    public function beforeRequest($controller);

    public function afterRequest($controller);
}