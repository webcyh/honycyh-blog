<?php


namespace model;

use \core\Model;

/**
 * LoginModel
 */
class Posts extends Model
{
    protected $table = "posts";
    protected $pk = "ID";

    public function getNews()
    {
        return $this->conn->
        table($this->table)->
        order('date desc')->
        limit('0,15')->select();
    }

    public function getPostById($tag)
    {
        return $this->conn->
        table($this->table)->
        where('tag=' . $tag)->select();
    }

    public function addPost($posts)
    {
        return $this->insert($posts);
    }

    public function getPostsByCatId($catId)
    {
        return $this->conn->
        table($this->table)->
        where('catId=' . $catId)->select();
    }

    //获取指定指定范围的数据
    public function getPostOffsetLimit($catId,$offset,$limit)
    {
        $rst =  $this->conn->
        table($this->table)->
        where('catId=' . $catId)->order('ID desc')->limit(($offset*$limit).','.$limit)->select();
       return $rst;
    }
}
