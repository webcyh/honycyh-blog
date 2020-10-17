<?php
/**
 * 构造函数完成参数的配置
 * 将sql查询语句分为 table field where group having limit
 * 使用链式调用
 * 对于select语句返回结果集
 * 对于insert返回自增id
 * update delete 语句返回影响行数
 *
 * 细节：引号问题
 */

namespace Core\Database;
class Db
{
    //主机名
    protected $host;
    //用户名
    protected $user;
    //密码
    protected $pwd;
    //数据库名
    protected $dbname;
    //字符集
    protected $charset;
    //表前缀
    protected $prefix;
    //数据库名
    protected $tableName;
    //链接资源
    protected $link;
    //sql语句
    protected $sql;
    //操作数据
    protected $options = [];
    //构造方法 初始化变量
    protected static $Instance = null;

    public function __construct()
    {
        $cfg = cfg('db');
        $this->host = $cfg['host'];
        $this->user = $cfg['user'];
        $this->pwd = $cfg['passwd'];
        $this->dbname = $cfg['database'];
        $this->charset = $cfg['charset'];
        $this->prefix = $cfg['prefix'];
        $this->link = $this->connect();
        $this->initOptions();
    }

    private function connect()
    {
        $conn = \mysqli_connect($this->host, $this->user, $this->pwd, $this->dbname);
        if (!$conn) {
            die("连接错误: " . mysqli_connect_error());
        }
        return $conn;
    }

    //field方法
    function field($field)
    {
        //不为空继续
        if (!empty($field)) {
            if (is_string($field)) {
                $this->options['field'] = $field;
            } else if (is_array($field)) {
                $this->options['field'] = implode($field, ',');
            }
        }
        return $this;
    }

    /**
     * 实现单例模式 全局只有一个数据库实例对象
     */
    public static function getInstance()
    {
        if (self::$Instance == null) {
            self::$Instance = new self();
        }
        return self::$Instance;
    }

    //table方法
    public function table($table)
    {
        if (!empty($table)) {
            $this->options['table'] = $table;
        }
        return $this;
    }

    //where方法
    public function where($where)
    {
        if (!empty($where)) {
            $this->options['where'] = 'where ' . $where;
        }
        return $this;
    }

    //group方法
    public function group($group)
    {
        if (!empty($group)) {
            $this->options['group'] = 'group by ' . $group;
        }
        return $this;
    }

    //having方法
    public function having($having)
    {
        if (!empty($having)) {
            $this->options['having'] = 'having ' . $having;
        }
        return $this;
    }

    //order方法
    public function order($order)
    {
        if (!empty($order)) {
            $this->options['order'] = 'order by ' . $order;
        }
        return $this;
    }

    //limit方法
    public function limit($limit)
    {
        if (!empty($limit)) {
            $this->options['limit'] = 'limit ' . $limit;
        }
        return $this;
    }

    //query方法
    public function query($sql)
    {
        $sql = strtolower($sql);
        $newData = [];
        $result = mysqli_query($this->link, $sql);
        if ($result && mysqli_affected_rows($this->link)) {
            while ($data = mysqli_fetch_assoc($result)) {
                $newData[] = $data;
            }
            return $newData;
        }
    }

    //select方法
    public function select()
    {
        $sql = 'select %FIELD% from %TABLE% %WHERE% %GROUP% %HAVING% %ORDER% %LIMIT%';
        //替换占位符
        $sql = str_replace(['%FIELD%', '%TABLE%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%'], [$this->options['field'], $this->options['table'], $this->options['where'], $this->options['group'], $this->options['having'], $this->options['order'], $this->options['limit']], $sql);
        $this->sql = $sql;
        $this->initOptions();
        //执行返回数组
        return $this->query($sql);
    }

    //初始化options
    public function initOptions()
    {
        $arr = ['where', 'table', 'field', 'order', 'group', 'having', 'limit'];
        foreach ($arr as $value) {
            $this->options[$value] = '';
            if ($value == 'table') {
                //默认的数据库为设置
                $this->options[$value] = $this->tableName;
            } else if ($value == 'field') {
                $this->options['field'] = '*';
            }
        }
    }

    public function __get($name)
    {
        if ($name == 'sql') {
            return $this->sql;
        }
        return false;
    }

    //insert关联数组
    public function insert($data)
    {
        //处理值是字符串问题
        $data = $this->parseValue($data);
        $key = array_keys($data);
        $value = array_values($data);
        $sql = 'insert into %TABLE%(%FIELD%) values (%VALUES%)';
        $sql = str_replace(['%TABLE%', '%FIELD%', '%VALUES%'], [$this->options['table'], implode($key, ','), implode($value, ',')], $sql);
        $this->sql = $sql;
        return $this->exec($sql, true);

    }

    //exec方法 影响行数 id等 插入操作返回真或者假 删除或者修改返回影响行数
    public function exec($sql, $isinsert = false)
    {
        $result = mysqli_query($this->link, $sql);
        if ($result && mysqli_affected_rows($this->link)) {
            if ($isinsert) {
                return mysqli_insert_id($this->link);
            } else {
                return mysqli_affected_rows($this->link);
            }
        }

        return false;
    }

    //处理数组值问题
    public function parseValue($data)
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $value = '"' . $value . '"';
            }
            $newData[$key] = $value;
        }
        return $newData;
    }

    //delete
    public function delete()
    {
        $sql = 'delete from %TABLE% %WHERE%';
        $sql = str_replace(['%TABLE%', '%WHERE%'], [$this->options['table'], $this->options['where']], $sql);
        $this->sql = $sql;
        return $this->exec($sql);
    }

    //update
    public function update($data)
    {
        $data = $this->parseValue($data);
        $value = $this->parseUpdate($data);
        $sql = 'update %TABLE% set %VALUE% %WHERE%';
        $sql = str_replace(['%TABLE%', '%VALUE%', '%WHERE%'], [$this->options['table'], $value, $this->options['where']], $sql);
        $this->sql = $sql;
        return $this->exec($sql);

    }

    public function parseUpdate($data)
    {
        foreach ($data as $key => $value) {
            $newData[] = $key . '=' . $value;
        }
        return implode($newData, ',');
    }

    //聚合函数
    public function max($field)
    {
        $result = $this->field('max(' . $field . ') as max')->select();
        //返回的是二维数组
        return $result[0]['max'];

    }

    public function selectDb($db)
    {
        $result = mysqli_query($this->link, 'use ' . $db);

        return $result;
    }

    //触发时候 是对象被销毁的时候调用
    public function __destruct()
    {
        if ($this->Link) {
            mysqli_close($this->Link);
        }
    }

    //没有指定方法时候自动调用该方法
    public function __call($func, $args)
    {
        $str = substr($func, 0, 5);
        $field = strtolower(substr($func, 5));
        if ($str == 'getby') {
            return $this->where($field . '="' . $args[0] . '"')->select();
        }
        return false;
    }

    public function lastInsertId()
    {
        return mysqli_insert_id($this->link);
    }

    //事务
    public function autoCommit($commit)
    {//是否开启
        return mysqli_autocommit($this->link, $commit);
    }

    //事务提交
    public function commit()
    {
        return mysqli_commit($this->link);
    }

    public function rollback()
    {
        return mysqli_rollback($this->link);
    }

}
