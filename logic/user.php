<?php


namespace logic;
class User extends \core\Logic
{
    public function add()
    {
        $_SESSION['ID'] = 1;
    }

    public function checkLogin()
    {
        if ($_SESSION['ID']) {
            if (!isset($_SESSION['user_info'])) {
                p('数据库');
                $data = M('User')->getRow($_SESSION['ID']);
                /**
                 * 获取权限
                 */
                $data['RoleId'] = M('UserRole')->getRow($data['ID'])['RoleId'];
                $data['action'] = $this->getAction(M('BlogRole')->getAction($data['RoleId']));
                $_SESSION['user_info'] = $data;
            } else {
                $data = $_SESSION['user_info'];
            }
            return $data;
        } else {
            return false;
        }
    }

    /**
     * 根据actionId 返回对应的名称和方法
     * @return [type] [description]
     */
    public function getAction($arr)
    {
        if (!empty($arr)) {
            $data = [];
            foreach ($arr as $key => $value) {
                $data [] = M('FuncAction')->getRow($value['actionId']);
            }
            return $data;
        }
        return false;
    }
}