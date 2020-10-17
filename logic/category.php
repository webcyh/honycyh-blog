<?php

namespace logic;
class Category extends \core\Logic
{
    /**
     * 注意这里的逻辑处理 应该先判断是否已经存储在缓存当中 如果没有将到数据库当中取数据
     */
    public function getAll()
    {
        /**
         * 调用注入 动态代理cache类方法
         */
#		$rst = $this->getCache('category');
#		if(!$rst){
        $rst = M('Category')->getAll();
#			$this->setCache('category',$rst);
#		}
        return $rst;
    }
}
