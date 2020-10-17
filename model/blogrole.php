<?php

namespace model;

use \core\Model;

/**
 * LoginModel 角色权限
 */
class BlogRole extends Model
{
    protected $table = 'blog_role';
    protected $pk = 'RoleId';

    public function getAction($RoleId)
    {
        return $this->conn->table($this->table)->where('RoleId=' . $RoleId)->select();
    }
}