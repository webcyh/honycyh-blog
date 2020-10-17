<?php

namespace model;

use \core\Model;

/**
 * LoginModel
 */
class Tags extends Model
{
    protected $table = "tags";
    protected $pk = "tagId";

    public function getNamesByTagId($ids)
    {
        $data = [];
        if (is_array($ids)) {
            foreach ($ids as $key => $value) {
                $rst = $this->conn->table($this->table)->where('tagId=' . $value['tagids'])->select();
                $data[] = $rst ? $rst[0] : [];
            }
        } else {
            $data = $this->conn->table($this->table)->where('tagId=' . $ids)->select();
            return empty($data) ? [] : $data[0];
        }
        return $data;
    }

    public function getTagIdByNames($tagname)
    {
        return $this->conn->table($this->table)
            ->field('tagId,postnum')->where('tagname="' . $tagname . '"')
            ->select();
    }

    public function addTag($tag)
    {
        return $this->conn->insert($tag);
    }

    public function addPostNum($tag)
    {
        return $this->conn->table($this->table)->where('tagname="' . $tag['tagname'] . '"')->update($tag);
    }
}
