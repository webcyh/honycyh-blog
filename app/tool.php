<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-06 17:40:56
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-08 20:01:46
 */

namespace App;

use \Core\Controller;
use \Lib\Vcode;

class tool extends Controller
{

    public function checkLogin($tpl)
    {

    }

    public function getCode()
    {
        $i = new Vcode(45, 140, 5);
        echo $i;
    }

    public function curl()
    {

        /**
         * $curl = curl_init('http://www.baidu.com');
         * curl_exec($curl);
         * curl_close($curl);//直接爬取内容下来
         */
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.baidu.com');
        $ouput = curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//直接爬取内容下来
        curl_close($curl);
        echo str_replace('百度', '换行', $ouput);
    }
}