<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-19 22:18:04
 * @Last Modified by:   webcyh
 * @Last Modified time: -03-09 13:50:36
 */


function p($msg)
{
    echo '<pre style="border:1px solid blue;overflow:auto;font-size:17px;background:black;box-sizing:border-box2020;color:white;">';
    print_r($msg);
    echo '</pre>';
}

/**
 * 处理所有未处理的异常
 */
function myException($exception)
{
    echo "<b>Exception:</b> ", $exception->getMessage();
}

/**
 * 助手函数
 */
//逻辑层
function L($logic)
{
    return \Core\Register::_get('\logic\\' . $logic);
}

//业务层
function M($model)
{
    return \Core\Register::_get('\model\\' . $model);
}

//视图层
function V($validate)
{
    return \Core\Register::_get('\validate\\' . $validate);
}

//get数组
function get($key = '')
{
    if (!$key) {
        return \Core\Core::params('get');
    } else {
        return \Core\Core::params('get', $key);
    }
}

//post数组
function post($key = '')
{
    if (!$key) {
        return \Core\Core::params('post');
    } else {
        return \Core\Core::params('post', $key);
    }
}

//配置
function cfg($key)
{
    return \Core\Register::_get('\Core\Config')->get($key);
}


//转换为xml2arr
function xml($arr, &$xml_data)
{
    foreach ($arr as $key => $value) {
        if (is_numeric($key)) {
            $key = 'item' . $key;
        }
        if (is_array($value)) {
            $subnode = $xml_data->addChild($key);
            xml($value, $subnode);
        } else {
            $xml_data->addChild($key, htmlspecialchars($value));
        }
    }
}


//重定向
function redirect($action, $data)
{
    $arr = explode('.', $action);
    $action = $arr[0];
    $method = isset($arr[1]) ? $arr[1] : '';
    header("refresh:0.5;url=http://honycyh.cn/index/home");
    extract($data);
    $file = VIEW . '/home/jump' . EXT;
    mvc_require($file);
    exit;
}

//传递数组 并且递归当前这一层 如果当前的层次跟 如果当前的结点cid跟跟结点一致
function classify($arr, $cid)
{
    //用一个数组保存当前的树
    $data = [];
    //遍历所有的数据
    foreach ($arr as $key => $value) {
        //查找$cid 的孩子结点 如果当前这个结点
        if ($value['cid'] == $cid) {
            //保存下该节点
            $rst = $value;
            //遍历他的孩子结点
            $r = classify($arr, $value['id']);
            //保存他的孩子结点
            $r && $rst['childs'] = $r;
            $data[] = $rst;
        }
    }
    return $data;
}

/**
 * 统计 消耗时间和内存
 *
 */
function getusagetimeandmemary()
{
    define('stratTime', microtime(true));
    define('startMemory', memory_get_usage());
}


function getusagetimeandmemaryend()
{
    $runtime = (microtime(true) - stratTime) * 1000; //将时间转换为毫秒
    $usedMemory = (memory_get_usage() - startMemory) / 1024;
    p("运行时间: {$runtime} 毫秒<br />");
    p("耗费内存: {$usedMemory} K");
}

//获取客户端IP
function getIp()
{
    if ($_SERVER["HTTP_CLIENT_IP"] && strcasecmp($_SERVER["HTTP_CLIENT_IP"], "unknown")) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } else {
        if ($_SERVER["HTTP_X_FORWARDED_FOR"] && strcasecmp($_SERVER["HTTP_X_FORWARDED_FOR"], "unknown")) {
            $ip = $_SER["HTTP_X_FORWARDED_FOR"];
        } else {
            if ($_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],
                        "unknown")
                ) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = "unknown";
                }
            }
        }
    }
    return ($ip);
}


function mvc_require($file)
{
    $file = strtolower(str_replace('\\', DS, $file));
    if (file_exists($file)) {
        return require(strtolower(str_replace('/', DS, $file)));
    }
}

