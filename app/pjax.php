<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-27 15:26:58
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 10:03:34
 */

namespace App;

use Core\Controller;

class pjax extends Controller
{
    protected $view = BASE . DS . 'tpl';

    public function __construct($tpl)
    {
        $this->tpl = $tpl;
        $this->checkLogin($tpl);
    }

    public function checkLogin()
    {

    }

    public function tagDetail()
    {
        $posts = L('Posts')->getPostByTagId(get('tag'),0,5);

        if (!$posts) {
            $posts = [];
        }
        $count = count($posts);
        $tagname = M('Tags')->getNamesByTagId(get('tag'));
        empty($tagname) && $this->redirect(
            'home',
            ['msg' => '非法标签']
        );
        return [
            'tagname' => $tagname,
            'posts' => $posts,
            'count' => $count,
            'tagId'=>get('tag')
        ];
    }

    public function about()
    {
        return [

        ];
    }

    public function home()
    {
        return [
            'posts' => L('Posts')->getNews()
        ];
    }

    public function link()
    {
        return [
            'link' => L('Link')->getAll()
        ];
    }

    public function daily()
    {
        return [
            'diary' => L('diary')->getNew()
        ];
    }

    public function history()
    {
        return [

        ];
    }

    public function detail()
    {
        //验证
        V('posts')->check(['postId' => get('postId')]) ||
        $this->redirect(
            'Index.home',
            ['msg' => implode(V('posts')->errorMsg(), '|')]
        );
        //获取数据
        !empty(($detail = L('posts')->getPostById(get('postId')))) ||
        $this->redirect(
            'Index.home',
            ['msg' => '找不到相关信息']
        );

        return [
            'detail' => $detail
        ];
    }

    public function catDetail()
    {
        $posts = L('Posts')->getPostsByCatId(get('catId'),0,5);
        if (!$posts) {
            $posts = [];
        }
        $count = count($posts);

        if($count == 0){
            $msg ='本分类尚未发布文章';
            $code=0;
        }

        return [
            'posts' => $posts,
            'count' => $count,
            'code'=>$code,
            'msg'=>$msg,
            'catId'=>get('catId')
        ];
    }

    public function catDetailMore()
    {
        $posts = L('Posts')->getPostsByCatId(get('catId'),get('page')+0,5);
        if (!$posts) {
            $posts = [];
        }
        $count = count($posts);

        if($count == 0){
            $msg ='本分类尚未发布文章';
            $code=0;
        }
        return [
            'posts' => $posts,
            'count' => $count,
            'code'=>$code,
            'msg'=>$msg
        ];
    }


    public function tagDetailMore()
    {
        $posts = L('Posts')->getPostByTagId(get('tagId'),get('page')+0,5);

        if (!$posts) {
            $posts = [];
        }

        return [
            'posts' => $posts
        ];
    }
    public function book()
    {
        return [

        ];
    }
    //获取某篇文章下面的评论以及回复内容使用异步加载实现
}
