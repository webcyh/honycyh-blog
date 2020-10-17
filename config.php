<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-19 21:07:55
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 15:23:09
 */

//配置文件
return [
    'db' => [
        'dbtype' => 'mysql',
        //主机ip地址
        'host' => 'localhost',
        //端口号
        'port' => 3306,
        //用户账号
        'user' => 'root',
        //用户密码
        'passwd' => 'roottest',
        //数据库
        'database' => 'blog',
        //编码
        'charset' => 'utf-8',
        //表前缀
        'prefix' => 'blog_'
    ],
    'log' => [
        //使用一个日志文件
        'single' => true,
        //文件大小
        'file_size' => 2097152,
        //日志的位置
        'path' => LOG_PATH,
        //最多存在多少文件
        'max_files' => 0
    ],
    'redis' => [
        //主机ip
        'host' => '127.0.0.1',
        //端口号
        'port' => 6379,
        //密码
        'password' => ''
    ],
    'upload' => [
        'path' => '/static/upload/',
        'maxsize' => 1024 * 10,
        'mine' => [
            'image/jpg',
            'image/jpeg',
            'image/gif',
            'image/wbmp',
            'image/png',
            'text/plain'
        ],
        'allowext' => ['jpg', 'jpeg', 'gif', 'wbmp', 'png', 'txt'],
        'ext' => 'png'
    ],
    'controller' => [
        'index' => [
            'decorator' => [
                '\decorator\template'
            ]
        ],
        'api' => [
            'decorator' => [
                '\decorator\json'
            ]
        ],
        'pjax' => [
            'decorator' => [
                '\decorator\pjax'
            ]
        ],
        'tool' => [
            'decorator' => [
                '\decorator\general'
            ]
        ]
    ],
    'exception_handler' => '\Lib\ExceptionHandler',
    'route' => '\Lib\Route'
];
