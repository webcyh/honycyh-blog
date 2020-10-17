<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-06 17:40:56
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-08 20:01:46
 */

namespace App;

use \Core\Controller;

class IndexBaseController extends Controller
{
    public function __construct($tpl)
    {
        //设置基本的模板
        $this->tpl = $tpl;
        //获取基本的数据
        $this->baseDate();
        //检查登录权限
        $this->checkLogin($tpl);
        //alter table posts add view int(7) not null default 0;
    }

    public function baseDate()
    {
        $this->UIData = [
            'infoArr' => L('Info')->getAll(),
            'category' => L('CateGory')->getAll(),
            'tags' => L('Tags')->getAll()
        ];
    }

    public function checkLogin()
    {

    }
}