<?php

/**
 * @Author: webcyh
 * @Date:   2020-03-05 16:39:01
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-09 09:32:53
 */
namespace logic;
class Link extends \core\Logic
{
	public function getAll()
	{
		$rst = $this->getCache('link');
		if(!$rst){
			DEBUG&&p('数据库');
			$rst = M('Link')->getAll();
			 $this->setCache('link',$rst); 
		}
		return $rst; 
	}	
}

