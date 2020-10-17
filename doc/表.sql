

# 插入时候需要 文章ID 内容 该用户昵称 邮箱地址 以及时间
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned DEFAULT NULL COMMENT '博客id',
  `content` text COMMENT '评论内容',
  `nickname` varchar(60) DEFAULT NULL COMMENT '冗余用户昵称',
  `email` varchar(60) DEFAULT NULL COMMENT '冗余用户邮箱地址',
  `thumb_img` varchar(255) default '/static/blog-logo.jpg' COMMENT '冗余用户头像',
  `is_reply` tinyint(2) unsigned DEFAULT '0' COMMENT '是否回复',
  `status` tinyint(2) unsigned  default 0 COMMENT '评论状态，-1为删除，0为待审核，1为已发布',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
);


/**
 * 实现思路：在文章ID为1下面发送评论 名字：webcyh 内容：hello 邮箱地址：呵呵 创建时间
 */


# 现在A 同学发出评论
insert into comment(topic_id,content,nickname,email,thumb_img,is_reply,status,create_time) values
  (1,"您好呀博主",'A','1992281294@qq.com','logo.jpg',1,1,131231233),
  (1,"hehe",'B','1992281294@qq.com','logo.jpg',1,1,131231123),
  (1,"asdf",'A','1992281294@qq.com','logo.jpg',1,1,131231123),
  (1,"asdfc",'D','1992281294@qq.com','logo.jpg',1,1,131233123);


# 插入时候需要 评论ID  回复ID 内容 该用户昵称 被回复的昵称 邮箱地址 回复评论或者回复 以及时间
CREATE TABLE `comment_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) unsigned DEFAULT NULL COMMENT '评论id',
  `reply_type` tinyint(2) unsigned DEFAULT '1' COMMENT '1为回复评论，2为回复别人的回复',
  `reply_id` int(10) unsigned DEFAULT NULL COMMENT '回复目标id，reply_type为1时，是comment_id，reply_type为2时为回复表的id',
  `content` text CHARACTER SET utf8 COMMENT '回复内容',
  `from_thumb_img` varchar(255) CHARACTER SET utf8 default '/static/blog-logo.jpg' COMMENT '回复者的头像',
  `from_nickname` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '回复者的昵称',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '评论时间',
  `to_nickname` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '冗余回复对象的昵称',
  `is_author` tinyint(2) unsigned DEFAULT NULL COMMENT '0为普通回复，1为后台管理员回复',
  PRIMARY KEY (`id`)
);

/**
 * 实现思路：给某个评论回复内容：
 * 比如给评论2发起内容
 */
# 在第1个评论下面有2条回复 还有2条回复 回复 内容 该用户昵称 邮箱地址 以及时间 
# 被回复者或者被评论的回复者（根据传递的type判断是否为回复回复）










