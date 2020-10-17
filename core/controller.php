<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-19 21:05:20
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 13:48:54
 */

namespace Core;

/**
 * 这个其实是模板模式 前端控制器模式的组合
 * 控制器调用相应的调度器[Model]处理业务逻辑
 * 并且返回相应的视图
 */
class Controller
{
    //不需要验证的请求
    public $mustCheckLogin = ['login', 'logincheck'];
    public $UIData = [];
    protected $tpl = '';
    protected $smarty = null;

    /**
     * 用来指定返回视图模板文件
     * @return [type] [description]
     */

    public function show($filename = '')
    {
        $file = $this->view . DS . $filename . '.' . EXT;
        if (file_exists($file)) {
            extract($this->UIData);
            include $file;
            exit;
        } else {
            die('找不到该模板文件');
        }
    }

    public function display($data)
    {
        extract($data);
        $file = $this->view . DS . $this->tpl . '.' . EXT;
        require($file);
    }

    public function pjax($data)
    {
        extract($data);
        $file = $this->view . DS . $this->tpl . '.' . EXT;
        require($file);
    }

    public function assign($key, $value)
    {
        $this->UIData[$key] = $value;
    }

    /**
     * 实现控制器之间的跳转
     */
    public function redirect($action, $data)
    {
        $arr = explode('.', $action);
        $action = $arr[0];
        $method = $arr[1] ? $arr[1] : '';
        if (!$method) {
            header("refresh:1;url=http://honycyh.cn" . '/' . $action);
        } else {
            header("refresh:1;url=http://honycyh.cn" . '/' . $action . '/' . $method);
        }
        exit;
        extract($data);
        $file = $this->view . DS . 'jump.' . EXT;
        include $file;
        exit;
    }
}
