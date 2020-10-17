<?php

namespace core;

use \core\register;
/**
 * 一个数据库工厂类
 */
class DbFactory
{
	
	public static function getdb($tyle){
		switch ($tyle) {
			case 'mysqli':
				return register::_get('\core\database\db');
				break;
			case 'redis':
				return register::_get('\core\cache\redis');
				break;
			default:
				return false;
				break;
		}
	}
}