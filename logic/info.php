<?php

namespace logic;
class Info extends \core\Logic
{
    /**
     * 注意这里的逻辑处理 应该先判断是否已经存储在缓存当中 如果没有将到数据库当中取数据
     */
    public function getAll()
    {
        /**
         * 调用注入 动态代理cache类方法
         */
        $rst = M('Info')->getAll();
        $infoArr = array_column($rst, null, 'info_name');
        return $infoArr;
    }
}
