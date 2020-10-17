<?php

namespace logic;
class Posts extends \core\Logic
{

    public function getAll()
    {
        $data = M('Posts')->getAll();
        return $data;
    }

    /**
     * 返回最新的三篇文章
     */
    public function getNews()
    {
        /**
         * 截取数据  合并标签  分类
         */
        $rst = $this->parse(M('Posts')->getNews());
#		if(!$rst){
#			DEBUG&&p('数据库');
#			$rst = $this->parse(M('Posts')->getNews());
#			 $this->setCache('posts',$rst); 
#		}
        return $this->parse(M('Posts')->getNews());;
    }

    public function parse($posts)
    {
        /**
         * 遍历内容并且添加标签
         */
        if (!empty($posts)) {
            $rst1 = M('CateGory')->getAll();
            $rst1 = array_column($rst1, null, 'ID');

            $tag = M('Tags')->getAll();
            $tag = array_column($tag, null, 'tagId');


            foreach ($posts as $key => $value) {
                //截取内容
                $posts[$key]['content'] = mb_substr($value['content'], 12, 100) . '.......';
                //内容
                $posts[$key]['content'] = htmlspecialchars(mb_substr($value['content'], 12, 100) . '.......');

                //获取分类
                $rst = isset($rst1[$value['catId']]) ? $rst1[$value['catId']] : [];

                $posts[$key]['catename'] = isset($rst['catName']) ? $rst['catName'] : "";

                //获取所有的标签Id
                $posts[$key]['tags'] = M('PostTotag')->getTagBypostId($value['ID']);
                //如果存在
                if (!empty($posts[$key]['tags'])) {
                    $g = [];
                    //转换为中文
                    foreach ($posts[$key]['tags'] as $k => $value) {
                        $g[$k]['tagname'] =
                            isset($tag[$value['tagids']]) ? $tag[$value['tagids']]['tagname'] : '威风标签';
                        $g[$k]['tagId'] = $tag[$value['tagids']]['tagId'];
                    }
                    $posts[$key]['tagnames'] = $g;
                } else {
                    $posts[$key]['tagnames'] = [];
                }


            }
            return $posts;
        } else {
            return [];
        }
    }

    public function getPostById($postId)
    {
        $data = M('Posts')->getRow($postId);
        if ($data) {
            /**
             * 获取到文章后同时 修改文章的阅览数量
             */
            $author = M('User')->getRow($data['author']);
            $data['author'] = isset($author['user_nicename']) ? $author['user_nicename'] : '未知';
            $data['content'] = html_entity_decode($data['content']);
            $data['comments'] = M('comment')->getCommentsByPostId($data['ID']);
        }
        return $data;
    }

    public function getPostByTagId($tagId,$offset,$limit)
    {


        $post = M('postTotag')->getPostOffsetLimit($tagId,$offset,$limit);
        $data = [];
        foreach ($post as $key => $value) {
            $data[] = $this->getPostById($value['postId']);
        }
        return $this->parse($data);
    }

    public function putcomment($data)
    {

        if ($this->getPostById($data['ID'])) {
            return M('comments')->insert([
                'comment_post_ID' => $data['ID'],
                'comment_author_email' => $data['email'],
                'comment_date' => date('Y-m-d H:i:s'),
                'comment_content' => htmlspecialchars($data['comment'])
            ]);
        }
    }

    //获取所有文章的评论
    public function getComments($posts)
    {
        foreach ($posts as $key => $value) {
            $posts[$key]['comments'] = M('comments')->getCommentByPostId($value['ID']);
        }
        return $posts;
    }

    public function getPostsByCatId($catId,$offset,$limit)
    {

        return $this->parse(M('Posts')->getPostOffsetLimit($catId,$offset,$limit));
    }

    public function addPost($post)
    {
        /**
         * 思路：
         * 遍历这些标签 如果已经存在++ 而且返回ID
         * 如果不存在 插入同时设置为1 并且返回ID
         * 保存当前的文章并且返回插入后的ID
         * 将文章ID 和ID插入标签文章表
         */
        M('posts')->autoCommit(false);//关闭自动提交
        //拆分$post 这里其实要使用事务 如果插入成功则完成否则回滚
        $tags = explode(',', $post['tags']);
        $rst1 = true;
        $rst2 = true;
        $tagIds = [];
        foreach ($tags as $key => $value) {
            $tagIds[] = L('tags')->isExists($value);
        }
        //保存当前的文章并且返回插入后的ID
        unset($post['tags']);
        $rst1 = M('posts')->addPost($post);

        $postId = M('posts')->lastInsertId();
        foreach ($tagIds as $key => $value) {
            $rst2 = M('PostToTag')->insert([
                'postId' => $postId,
                'tagIds' => $value
            ]);
            if (!$rst2) {
                break;
            }
        }
        if (!$rst1 || !$rst2) {
            M('posts')->rollback();
            return false;
        } else {
            M('posts')->commit();
        }
        return true;
    }
}

