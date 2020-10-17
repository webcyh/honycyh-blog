<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-19 21:05:07
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 13:51:57
 */

namespace Core;

use Core\Database\Db;

/**
 * baseModel 这里其实使用到了数据对象访问模式 实体映射模式[其实跟数据对象映射模式类似不过数据源不同 而且这里结合了模板模式 将共同的方法放在公共的baseModel当中 单独拥有的方法放在各自类当中]
 *
 * 模板方法的范围更为广 比如动物类 下面多个具体动物子类
 * 然而在这里的Model 是用来提供数据的 将数据表映射在baseModel当中 对于有些操作交给子类 相当于数据映射模式[也是数据访问对象模式 用于访问数据的对象]和模板设计模式的结合
 *
 *
 */
class Model
{
    protected $conn = null;


    protected $db = 'blog';

    public function __construct()
    {
        //获取数据库资源
        $this->conn = db::getInstance();

        //选择表
        $this->selectDb();
    }

    /**
     * 选择数据库
     */
    protected function selectDb()
    {
        $this->conn->selectDb($this->db);
    }

    /**
     * 获取所有的表数据
     * @return [type] [description]
     */
    public function getAll()
    {
        return $this->conn->table($this->table)->field('*')->select();
    }

    /**
     * 获取指定的列
     */
    public function getRow($id)
    {
        $row = $this->conn->table($this->table)->where($this->pk . '="' . $id . '"')->select();
        return $row ? $row[0] : [];
    }

    /**
     * 插入数据
     */
    public function insert($data)
    {
        return $this->conn->table($this->table)->insert($data);
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    //事务
    public function autoCommit($commit)
    {//是否开启
        return $this->conn->autoCommit($this->link, $commit);
    }

    //事务提交
    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollback()
    {
        return $this->conn->rollback();
    }


}
