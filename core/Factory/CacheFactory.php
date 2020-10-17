<?php

namespace core;

use \core\register;
/**
 * 一个数据库工厂类
 */
class CacheFactory
{
	
	public static function getcache($tyle){
		switch ($tyle) {
			case 'memcache':
				return register::_get('\core\cache\memcache');
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