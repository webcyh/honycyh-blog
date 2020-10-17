<?php

namespace Core\Cache;

use \Core\Register;

/**
 *
 */
class Redis
{
    protected $options = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 0,
        'timeout' => 0,
        'expire' => 0,
        'persistent' => true
    ];
    private static $ins = null;

    /**
     * 构造函数
     * @param array $options 缓存参数
     * @access public
     */
    public function __construct($options = [])
    {
        //判断是否已经开启扩展
        if (!extension_loaded('redis')) {
            //抛出错误函数调用
            throw new \BadFunctionCallException('not support: redis');
        }
        if ($configlog = Register::_get('\core\config')->get('redis')) {
            $configlog = array_merge($this->options, $configlog);
        }
        //合并参数
        if (!empty($options)) {
            $this->options = array_merge($configlog, $options);
        }


        //获取redis资源
        //pconnect脚本执行完成后还是连接着 
        //connect是脚本执行完成后断开连接
        $this->handler = new \Redis;
        if ($this->options['persistent']) {
            $this->handler->pconnect($this->options['host'], $this->options['port'], $this->options['timeout'], 'persistent_id_' . $this->options['select']);
        } else {
            $this->handler->connect($this->options['host'], $this->options['port'], $this->options['timeout']);
        }
        //如果有密码 将使用密码操作
        if ('' != $this->options['password']) {
            $this->handler->auth($this->options['password']);
        }

        if (0 != $this->options['select']) {
            $this->handler->select($this->options['select']);
        }
    }

    public static function getInstance()
    {
        if (!self::$ins) {
            self::$ins = new self();
        }
        return self::$ins;
    }

    /**
     * 判断缓存
     * @access public
     * @param string $name 缓存变量名
     * @return bool
     */
    public function has($key)
    {
        return $this->handler->exists($key);
    }

    /**
     * 读取缓存
     * @access public
     * @param string $name 缓存变量名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get($key, $default = false)
    {
        $value = $this->handler->get($key);
        if (is_null($value) || false === $value) {
            return $default;
        }

        try {
            //反序列化 并且返回
            $result = unserialize($value);
        } catch (\Exception $e) {
            $result = $default;
        }

        return $result;
    }

    /**
     * 写入缓存 这里的缓存主要用来缓存一些数据库取出来的数据
     * @access public
     * @param string $name 缓存变量名
     * @param mixed $value 存储数据
     * @param integer|\DateTime $expire 有效时间（秒）
     * @return boolean
     */
    public function set($key, $value, $expire = null)
    {
        if (is_null($expire)) {
            //使用默认的换出有效时间
            $expire = $this->options['expire'];
        }
        if ($expire instanceof \DateTime) {
            //
            $expire = $expire->getTimestamp() - time();
        }

        $value = serialize($value);
        if ($expire) {
            //指定的 key 设置值及其过期时间。如果 key 已经存在， SETEX 命令将会替换旧的值。
            $result = $this->handler->setex($key, $expire, $value);
        } else {
            $result = $this->handler->set($key, $value);
        }
        return $result;
    }

    /**
     * 自增缓存（针对数值缓存）
     * @access public
     * @param  string $name 缓存变量名
     * @param  int $step 步长
     * @return false|int
     */
    public function inc($key, $step = 1)
    {
        return $this->handler->incrby($key, $step);
    }

    /**
     * 自减缓存（针对数值缓存）
     * @access public
     * @param  string $name 缓存变量名
     * @param  int $step 步长
     * @return false|int
     */
    public function dec($key, $step = 1)
    {
        return $this->handler->decrby($key, $step);
    }

    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function rm($key)
    {
        return $this->handler->delete($key);
    }

    /**
     * 清除缓存
     * @access public
     * @param string $tag 标签名
     * @return boolean
     */
    public function clear()
    {
        return $this->handler->flushDB();
    }

    public function close()
    {
        return $this->handler->close();
    }

}
