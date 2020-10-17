<?php

namespace Lib;

use \Core\Exception;
/**
 * 这是自定义异常类
 */
class ArticleException extends Exception
{
	function __construct($message,$code=0)
	{
		parent::__construct($message,$code);
	}
}