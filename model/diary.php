<?php

namespace model;

use \core\Model;

/**
 * LoginModel
 */
class Diary extends Model
{
    protected $table = 'diary';
    protected $pk = 'ID';

    public function getNew()
    {
        return $this->conn->table($this->table)
            ->order('createTime desc')
            ->limit('1')->select();
    }
}