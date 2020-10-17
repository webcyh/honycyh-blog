<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-21 14:33:34
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-02-23 16:30:19
 */

namespace model;

use \core\Model;

/**
 * LoginModel
 */
class User extends Model
{
    protected $table = 'blog_users';
    protected $pk = 'ID';
}