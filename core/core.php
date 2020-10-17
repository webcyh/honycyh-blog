<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-19 21:16:18
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 13:47:53
 */

namespace Core;

class Core
{
    /**
     * 保存请求uri参数
     * @var array
     */
    private static $params = [];
    private static $postparams = [];

    /**
     * 默认访问的控制器
     * @var
     */
    public static $defaultAction = 'Index';
    /**
     * 默认访问的方法
     */
    public static $defaultMethod = 'index';

    public static $debugs = [
        'ip' => '',
        'method' => '',
        'host' => '',
        'uri' => ''
    ];

    /**
     * 行为：
     * 获取请求uri 根据uri 调用相关的控制器以及方法 并且将参数放在类属性当中 方便后边调用
     */
    public static function initPath()
    {
        /**
         * 获取请求参数并且保存起来
         * @var [type]
         */
        $pi = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        $route = \Core\Route::get($pi);
        $info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : self::$defaultAction;

        $route && ($info = $route);

        $pathinfo = explode('/', ltrim($info, '/'));
        self::$defaultAction = isset($pathinfo[0]) ? $pathinfo[0] : self::$defaultAction;
        self::$defaultMethod = isset($pathinfo[1]) ? $pathinfo[1] : self::$defaultMethod;

        self::$debugs['host'] = $_SERVER['HTTP_HOST'];
        self::$debugs['method'] = self::$defaultMethod;
        self::$debugs['ip'] = $_SERVER['SERVER_ADDR'];
        self::$debugs['uri'] = $_SERVER['REQUEST_URI'];


        self::$params = $_GET;
        self::$postparams = $_POST;

        unset($_GET);
        unset($_POST);
        unset($_SERVER);

    }

    /**
     * 开始请求
     * @return [type] [description]
     */
    public static function completerequest()
    {
        /**
         * 拼接得到请求路径
         */
        $ActionClass = '\App\\' . self::$defaultAction;
        $method = self::$defaultMethod;


        /**
         * 传递方法名
         * @var [type]
         */
        #p($ActionClass);exit;
        #class_exists($ActionClass)||redirect(
        #	'index.home',
        #	['msg'=>'找不到指定界面将跳转到首页']
        #);
        $obj = new $ActionClass($method);
        if (in_array($method, get_class_methods($ActionClass))) {
            /**
             * 改进 原始方法 我们可能返回json或者模板文件 所以
             * 这里使用装饰器模式 进行了解耦 为后期的代码维护 扩展提供了便捷
             *
             */
            /**
             * 获取所有的装饰器
             */
            $config = cfg('controller');
            $dec = $config[strtolower(self::$defaultAction)];
            if (isset($dec['decorator'])) {
                $decorators = [];
                foreach ($dec['decorator'] as $key => $value) {
                    $decorators[] = new $value();
                }
            }
            /*
            * 初始化装饰器
            */
            foreach ($decorators as $key => $value) {
                $value->beforeRequest($obj);
            }
            /**
             * 为了防止控制器方法没有返回值 所以这里做了判断 将没有返回值的转换为1为真 如果为真赋值为空数组 为假 那么使用返回值
             * @var [type]
             */
            $data = $obj->$method();
            $data = !$data ? [] : $data;
            //合并数据
            $data = array_merge($data, $obj->UIData);
            /**
             * 调用装饰器完成
             * @var [type]
             */
            foreach ($decorators as $key => $value) {
                $value->afterRequest($data);
            }
        } else {
            $obj->redirect(
                'Index.home',
                ['msg' => '找不到相关界面将跳转到首页']
            );
        }
    }

    public static function params($type = 'get', $key = '')
    {
        if ($type == 'get') {
            if (isset($key) && isset(self::$params[$key])) {
                return self::$params[$key];
            } else {
                return self::$params ? self::$params : false;
            }
        } else {
            if (isset($key) && isset(self::$postparams[$key])) {
                return self::$postparams[$key];
            } else {
                return self::$postparams ? self::$postparams : false;
            }
        }
    }

    /**
     * 时候调用该函数完成调用
     * 完成自动加载 在遇到需要实例的类 一般都是没有存在时候才调用该函数
     */
    public static function coreautoload($class)
    {

        //拼接成文件路径
        $file = BASE . '\\' . $class . '.php';
        //判断文件是否存在
        return mvc_require($file);
    }

    /**
     * 初始化路由 获取参数
     * 开始请求该控制器
     * @return [type] [description]
     */
    public static function run()
    {
        //完成初始化信息
        self::initPath();
        //开始请求该路径
        self::completerequest();//完成请求
        DEBUG && getusagetimeandmemaryend();
    }
}

//注册自动加载
spl_autoload_register('\core\Core::coreautoload');

