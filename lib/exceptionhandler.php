<?php

namespace lib;
/**
 * 触发异常的时候先经过这里
 */
class ExceptionHandler
{
	public static function render($exception)
	{
		if($exception instanceof \Lib\ArticleException){
			p("ArticleException".$exception->getMessage());
		}
	}
}