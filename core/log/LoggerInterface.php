<?php

namespace core\log;


/**
 * 
 */
interface LoggerInterface
{
	
	abstract public function debug($string);
	abstract public function info($string);
	abstract public function notice($string);
	abstract public function waring($string);
	abstract public function error($string);
	abstract public function critial($string);
	abstract public function alert($string);
	abstract public function emergency();
	abstract public function log($level='debug',$string);//错误产生将抛出异常


}