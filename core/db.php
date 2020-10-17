<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-19 21:04:13
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-02-23 16:07:55
 */


namespace Core;

/**
 * Db 数据库类
 */
Interface Db
{
	public function connect($host, $username, $passwd, $database);
	public function query($sql);
	public function close();
}
