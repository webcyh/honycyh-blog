<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-27 15:26:58
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 10:03:34
 */

namespace App;

use \Core\Controller;

class Api extends Controller
{
    protected $view = BASE . DS . 'tpl';

    public function __construct($tpl)
    {
        $this->tpl = $tpl;
        $this->checkLogin($tpl);
    }

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

    public function addrole()
    {
        return L('role')->addrole();
    }

    public function userList()
    {
        return [
            'userlist' => [
                [
                    "src" => "https://dss2.bdstatic.com/6Ot1bjeh1BF3odCf/it/u=1798368125,2239530857&fm=74&app=80&f=JPEG&size=f121,121?sec=1880279984&t=a79cdb0523a694c4a61a26a37c8597fa",
                    "title" => "订阅号",
                    "num" => 3,
                    "content" => "算法分析fuck you"
                ],
                [
                    "src" => "https://dss2.bdstatic.com/6Ot1bjeh1BF3odCf/it/u=1798368125,2239530857&fm=74&app=80&f=JPEG&size=f121,121?sec=1880279984&t=a79cdb0523a694c4a61a26a37c8597fa",
                    "title" => "订阅号",
                    "num" => 3,
                    "content" => "算法分析fuck you"
                ],
            ],
            'userInfo' => [
                'logo' => 'https://dss2.bdstatic.com/6Ot1bjeh1BF3odCf/it/u=1798368125,2239530857&fm=74&app=80&f=JPEG&size=f121,121?sec=1880279984&t=a79cdb0523a694c4a61a26a37c8597fa',
                'id' => '微信号：CYH11231233',
                'username' => 'ToBeMiracle'
            ]
        ];


    }

    //上传图片
    public function uploadImage()
    {
        $upload = new \lib\tools\Upload();
        if ($upload->uploadFile("imageFile")) {
            /**
             * 上传成功后存储到数据库当中
             */
            return [
                'success' => true,
                'message' => '/upload/' . $upload->newName,
                'filename' => '/upload/' . $upload->newName
            ];
        } else {
            return [
                'success' => false,
                'message' => "错误",
                'filename' => '/upload/' . $upload->newName
            ];
        }
    }

    //评论操作

    //评论操作
    public function comment()
    {
        /**
         * 获取邮箱地址
         * 评论的文章id
         * 昵称
         * http地址 验证后 插入
         * 评论成功后插入到该位置
         */
        $data = post();
        $data['content'] = htmlspecialchars($data['content']);
        $data['nickname'] = htmlspecialchars($data['nickname']);
        $data['email'] = htmlspecialchars($data['email']);

        if (!V('comment')->check(post())) {
            return array_merge(['status' => 0, 'msg' => V('comment')->errorMsg()], $data);
        } else {
            if (M('comment')->addComment(post())) {
                return array_merge(['status' => 1, 'msg' => '添加成功'], $data);
            }
            return array_merge(['status' => 0, 'msg' => '评论失败'], $data);
        }
    }

    //回复操作
    public function reply()
    {
        /**
         * 获取评论id是否为回复评论还是回复回复
         * 获取内容
         * 获取邮箱地址
         * 被评论者的昵称
         * 获取回复昵称
         * 执行完成后直接插入在该位置
         */

        return array_merge(['status' => 1], post());
    }
}
