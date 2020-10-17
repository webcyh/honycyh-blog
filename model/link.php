<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-08 21:00:37
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-08 21:41:48
 */

/**
 * 对于单独实体具有的方法应该写到实体类当中
 * 并且将公共方法抽取出来放到Model类当中
 */

namespace model;

use \core\Model;

class Link extends Model
{
    //指定操作的表
    protected $table = "link";
    //指定查询的主键
    protected $pk = "user_email";

    public function getAll()
    {
        return $this->conn->table($this->table)->field('link_id,link_url,link_title')->select();
    }

}

