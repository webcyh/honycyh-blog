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
class login extends Validate{
	protected $data = [
		'email',
		'nickname',
		'password'
	];
	protected $rulues = [
			'email'=>'required|email',
			'nickname'=>'required|length1,10',
			'password'=>'required|length6,10'
	];
	protected $msg = [
		'email'=>'邮箱是必须的并且为正规邮箱地址',
		'nickname'=>'昵称为长度在1到10之间的汉字和字母组成',
		'password'=>'密码长度在6到10之间的字母和数字下划线'
	];
}