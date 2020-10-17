<?php

namespace model;

use \core\Model;

/**
 * LoginModel
 */
class PostToTag extends Model
{
    protected $table = 'posttotag';

    public function getTagBypostId($postId)
    {
        return $this->conn->table($this->table)->field(['tagIds'])->where('postId=' . $postId)->select();
    }

    public function getPostByTagId($tagId)
    {
        return $this->conn->table($this->table)->where('tagIds=' . $tagId)->select();
    }

    public function getPostOffsetLimit($tagIds,$offset,$limit)
    {
        $rst =  $this->conn->
        table($this->table)->
        where('tagIds=' . $tagIds)->order('ID desc')->limit(($offset*$limit).','.$limit)->select();
        return $rst;
    }
}
