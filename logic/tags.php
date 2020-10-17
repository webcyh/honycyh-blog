<?php

namespace logic;
class Tags extends \core\Logic
{
    public function getAll()
    {
#		$rst = $this->getCache('tags');
#		if(!$rst){
#			DEBUG&&p('数据库');
        $rst = M('Tags')->getAll();
#			 $this->setCache('tags',$rst); 
#		}
        return $rst;
    }

    public function isExists($tagName)
    {
        $row = M('tags')->getTagIdByNames($tagName)[0];
        //如果存在直接修改
        if ($row) {
            $lastInsertId = $row['tagid'];
            M('tags')->addPostNum([
                'tagname' => $tagName,
                'postnum' => $row['postnum'] + 1
            ]);
        } else {
            //插入数据库
            M('tags')->insert([
                'tagname' => $tagName,
                'postnum' => 1
            ]);

            $lastInsertId = M('tags')->lastInsertId();

        }
        return $lastInsertId;
    }
}
