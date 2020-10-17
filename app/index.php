<?php
/**
 * @Author: webcyh
 * @Date:   2020-02-19 23:04:14
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 15:17:05
 * yum install mariadb mariadb-server chown -R mysql:mysql /var/lib/mysql/
 * systemctl start mariadb
 */

namespace App;

class Index extends IndexBaseController
{
    public function __construct($tpl)
    {
        parent::__construct($tpl);
    }


    /**
     * 指定模板的路径
     * @var [type]
     */
    protected $view = HOME;

    /**
     * 主界面
     */
    public function home()
    {
        echo 1;
        return [
            'posts' => L('Posts')->getNews()
        ];
    }

    /**
     * 关于我的界面
     */
    public function about()
    {
        return [
            'tags' => L('Tags')->getAll()
        ];
    }

    /**
     * 我的日记
     */
    public function daily()
    {
        return [
            'diary' => L('diary')->getNew()
        ];
    }

    public function history()
    {
        return [
            'link' => L('Link')->getAll()
        ];
    }

    /**
     * 文章详情界面
     */
    public function detail()
    {
        //验证
        V('posts')->check(['postId' => get('postId')]) ||
        $this->redirect(
            'home',
            ['msg' => implode(V('posts')->errorMsg(), '|')]
        );
        //获取数据
        !empty(($data = L('posts')->getPostById(get('postId')))) ||
        $this->redirect(
            'home',
            ['msg' => '找不到相关信息']
        );
        //最终结果
        return [
            'detail' => $data
        ];
    }

    public function link()
    {

        return [
            'link' => L('Link')->getAll()
        ];
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

    //分类的所有文章 默认获取前面5条文章
    public function catDetail()
    {
        $posts = L('Posts')->getPostsByCatId(get('catId'),0,5);
        if (!$posts) {
            $posts = [];
        }
        $count = count($posts);
        return [
            'posts' => $posts,
            'count' => $count,
            'catId'=>get('catId')
        ];
    }
}
