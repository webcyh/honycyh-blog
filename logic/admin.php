<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-07 10:35:11
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 13:41:34
 */

namespace logic;

class Admin
{
    /**
     * 获取全部管理员数据
     * @return [type] [description]
     */
    public function list()
    {
        //获取所有的数据
        return M('Admin')->getAll();
    }

    /**
     * 登录验证逻辑
     */
    public function login($data)
    {
        /**
         * 根据该邮箱获取信息 判断是否匹配
         */
        $rst = M('Admin')->getRowByEmail($data['email']);
        //判断是否一致
        $result = M('Admin')->isExist($rst[0], $data);
        $result && $_SESSION['Admin'] = true;
        //返回结果
        return $result;
    }

    /**
     * 添加管理员
     */
    public function add($data)
    {
        return M('admin')->add($data);
    }

    /**
     * 获取所有的角色
     */
    public function getRoles()
    {
        $data = M('blogrole')->getAll();
        foreach ($data as $key => $value) {
            $data[$key]['actions'] = L('User')->getAction(M('BlogRole')->getAction($value['RoleId']));
        }
        return $data;
    }
}
