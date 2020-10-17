<?php

namespace logic;
class UserRole extends \core\Logic
{
    /**
     * 注意这里的逻辑处理 应该先判断是否已经存储在缓存当中 如果没有将到数据库当中取数据
     */
    public function getAll()
    {
        return M('UserRole')->getAll();
    }
}