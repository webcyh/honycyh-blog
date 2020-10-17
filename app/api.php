<?php

namespace App; // 前面插入空行

use \Core\Controller; // 前面插入空行
use \Core\Test as Fuck; // 前面插入空行


// class Api extends Controller implements \ArrayAccess, \Countable

//或者
// class Api extends Controller implements 
//     \ArrayAccess, 
//     \Countable
class Api extends Controller 
{ // 花括号自成一行

    // 常量为大写
    const VERSION = '1.0';
    const DATE_APPROVED = '2020-06-01';
    const isGo = true;// 关键字为小写

    // 属性可以是 大驼峰小驼峰下划线分割线 必须添加访问修饰符 abstract final必须在访问修饰符前面 static在访问之后
    final private static fuck = 1;

    // 属性前面必须加修饰符 不可以用var声明
    protected $view = BASE . DS . 'tpl';

    public function __construct($tpl)
    {  // 花括号自成一行

        // 保存视图
        $this->tpl = $tpl;
        // 检查是否登录了
        $this->checkLogin($tpl);
    }

    // 小驼峰 必须添加修饰符
    public function loginCheck()
    {
        $email = post('email');
        $password = post('password');
        return [
            'status' => 1,
            'message' => '成功',
            'data' => [$email, $password]
        ];
    }

    public function adminlist()
    {
        $data = L('admin')->list();

        // 控制结构关键字前后空格  并且花括号同行
        if (empty($data)) {
            return ['code' => 1];
        }

        return [
            'code' => 0,
            'data' => $data
        ];
    }

    public function edit()
    {

    }

    public function checkLogin($tpl)
    {

    }

    public function adminaddjson()
    {
        $data['username'] = post('username');
        $data['email'] = post('email');
        $data['password'] = post('password');
        /**
         * 验证管理员注册信息
         */
        $rst = V('adminregister')->check($data);

        $response = [];
        //判断是否验证通过
        if ($rst) {
            //添加数据
            $result = L('admin')->add($data);
            //根据状态返回
            if ($result) {
                $response['status'] = 1;
                $response['msg'] = '注册成功';
            } else {
                $response['status'] = 0;
                $response['msg'] = '请填写正确的注册资料';
            }
        } else {
            $response['status'] = 0;
            $response['msg'] = '请填写正确的注册资料';
        }

        return $response;
    }

    // 添加角色
    public function addrole()
    {
        return L('role')->addrole();
    }


    //上传图片
    public function uploadImage()
    {
        // 获取上传实例对象
        $upload = new \lib\tools\Upload();

        // 上传文件
        if ($upload->uploadFile("imageFile")) {

            // 返回成功信息
            return [
                'success' => true,
                'message' => '/upload/' . $upload->newName,
                'filename' => '/upload/' . $upload->newName
            ];
        } else {

            // 失败了
            return [
                'success' => false,
                'message' => "错误",
                'filename' => '/upload/' . $upload->newName
            ];
        }
    }

    //测试  参数后边有空格 太长时候
    public function test(
        $arg1, 
        $arg2, 
        $arg3 = [], 
        $arg3 = []
    ) {
        // 调用时候有空格
        $this->test(
            1, 
            2, 
            3
        );
    }
    //评论操作
    public function comment()
    {
        $data = post();

        // 序列化
        $data['content'] = htmlspecialchars($data['content']);
        $data['nickname'] = htmlspecialchars($data['nickname']);
        $data['email'] = htmlspecialchars($data['email']);

        // 检查评论 
        if (!V('comment')->check(post())) {

            // 评论失败
            return array_merge(['status' => 0, 'msg' => V('comment')->errorMsg()], $data);
        } else {

            if (M('comment')->addComment(post())) {

                // 评论成功
                return array_merge(['status' => 1, 'msg' => '添加成功'], $data);
            }

            // 系统导致评论失败
            return array_merge(['status' => 0, 'msg' => '评论失败'], $data);
        }
    }
}
