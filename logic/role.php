<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-07 15:02:43
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 13:43:47
 */

namespace logic;
class Role
{
    public function addRole()
    {
        /**
         * 验证role
         */
        $rolename = get('rolename');
        if (!$rolename) {
            return false;
        }
        return M('Role')->create(['rolename' => $rolename]);
    }

    public function getAll()
    {
        return M('BlogRole')->getAll();
    }
}