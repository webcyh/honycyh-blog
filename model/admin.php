<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-06 18:20:01
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-08 21:41:24
 */
namespace model;
use \core\Model;
/**
 * LoginModel
 */
class Admin extends Model
{
	protected $table = "blog_admin";
	protected $pk = "ID";
	/**
	 * 判断取出的数据 跟 传递过来的数据是否一致
	 */
	public function isExist($rst,$data){
		$data["password"] = md5(trim($data["password"]));
		return $data["password"]==$rst["user_pass"]&&$data["email"]==$rst["user_email"];
	}
	public function add($data){
		$time = time();
		$data["password"] = md5(trim($data["password"]));
		$data = [
			'user_pass'=>$data['password'],
			'user_email'=>$data['email'],
			'user_nicename'=>$data['username'],
			'user_registered'=>date("Y-m-d H:i:s",time()),
			'display_name'=>$data['username']
			];
		return $this->insert($data);
	}
	/**
	 * 通过有线找到指定的数据
	 */
	public function getRowByEmail($email){
		return $this->conn->table($this->table)->where("user_email='$email'")->select();
	}
}