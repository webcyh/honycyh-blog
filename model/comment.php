<?php

namespace model;

use \core\Model;

/**
 * LoginModel
 */
class comment extends Model
{
    protected $table = 'comment';
    protected $pk = 'id';

    public function addComment($data)
    {
        $data = [
            'topic_id' => $data['topic_id'],
            'content' => htmlspecialchars($data['content']),
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'create_time' => time()
        ];
        return $this->insert($data);
    }

    public function getCommentsByPostId($postId)
    {
        return $this->conn->
        table($this->table)->
        order('create_time asc')->where('topic_id=' . $postId)
            ->select();
    }
}
