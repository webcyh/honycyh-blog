<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-07 08:41:11
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-07 08:41:47
 */
namespace validate;
use core\Validate;
/**
 * 定义检验的字段 以及 错误信息
 * 登录时候 有的字段 邮箱{} 昵称{中文英文不包含空格下划线} 密码{6到12位并且包含字母} 
 */
class adminregister extends Validate{
	protected $data = [
		'email',
		'username',
		'password'
	];
	protected $rulues = [
			'email'=>'required|email',
			'username'=>'required|length1,10',
			'password'=>'required|length6,10'
	];
	protected $msg = [
		'email'=>'邮箱是必须的并且为正规邮箱地址',
		'username'=>'昵称为长度在1到10之间的汉字和字母组成',
		'password'=>'密码长度在6到10之间的字母和数字下划线'
	];
}