<?php

namespace core;
/**
 * 如果有多个 在捕获多个基类时候顺序无关系而且基类也可以调用自定义异常类的方法
 * 一般将基类放在最尾 捕获到基类时候停止脚本执行
 */
class Exception extends \Exception
{

    function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        $message = "<h2>出现异常了</h2>";
        $message .= "<p>" . __CLASS__ . "[{$this->code}]:{$this->message}</p>";
        return $message;
    }
}