<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-20 10:46:23
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-02-20 14:27:29
 */
/**
 * 该拦截器防止上传时候防止sql攻击以及 xxs攻击
 */

namespace validate;
use core\Validate;
/**
 * 定义检验的字段 以及 错误信息
 * 登录时候 有的字段 邮箱{} 昵称{中文英文不包含空格下划线} 密码{6到12位并且包含字母} 
 */
class comment extends Validate{ 
	protected $data = [
		'topic_id',
		'content',
		'nickname',
		'email'
	];
	protected $rulues = [
		'topic_id'      => 'required|int',
		'content' => 'required|isOk',
		'nickname'=>'required|length3,10',
		'email'   => 'email|isStartWith'
	];
	protected $msg = [
		'topic_id'=>'必须为正整数',
		'content'=>'不能包含敏感词只能为纯文字并且长度为10到30个字符',
		'nickname'=>'昵称不能为空',
		'email'=>'邮箱是必须的并且为正规邮箱地址'
	];
	/**
	 * 自定义验证方法
	 */
	public function isStartWith($v)
	{
		
		return true;
	}
	public function isOk($v){
		return strlen(trim($v))>5;
	} 
}
