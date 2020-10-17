<?php


//设置跨域请求
header('Access-Control-Allow-Origin:*');
//设置时区
date_default_timezone_set("PRC");

//基本常量
defined('APP') || define('APP', BASE . '/app');
defined('CORE') || define('CORE', BASE . '/core');

defined('LIB') || define('LIB', BASE . '/lib');
defined('VIEW') || define('VIEW', BASE . '/view');
defined('STATIC') || define('STATIC', BASE . '/static');
defined('HOME') || define('HOME', VIEW . '/home');
defined('ADMIN') || define('ADMIN', VIEW . '/admin');
defined('EXT') || define('EXT', 'tpl');


defined('LOG_PATH') || define('LOG_PATH', BASE . '/log/');
defined('DEBUG') || define('DEBUG', true);

defined('BLOG_START_TIME') || define('BLOG_START_TIME', microtime(true));
session_start();

//加载函数库
include CORE . DS . 'function.php';
//引入核心文件

mvc_require(CORE . '/core.php');


//开始记录启动时间和内存
DEBUG && getusagetimeandmemary();



//注册自动加载
spl_autoload_register('\core\Core::coreautoload');

echo BASE . DS . 'core' . DS . 'base.php';
//获取设置的自定义异常类
//设置未捕获异常的处理函数
set_exception_handler(cfg('exception_handler') . '::render');

//检查是否定义路由规则
$route = cfg('route');
if ($route) {
    mvc_require(BASE . $route . '.php');
}



