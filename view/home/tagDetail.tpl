<?php include HOME.DS.'components'.DS.'header.tpl' ?>
<script src="/static/jquery.simpleLoadMore.js"></script>
<a  href="https://github.com/webcyh" class="git-link hidden-xs"></a>
 <section id="main" class="container">
   <div class="row">
       <div class="col-md-8 col-md-push-1 pjax">
        <div class="alert alert-success">当前标签:<?php echo $tagname['tagname'];?>  统计：<?php echo $count;?>篇文章</div>
       <!--写文章-->
        <div id="honycyhMore-box">
            <?php foreach ($posts as $key => $value) { ?>
            <div class="article">
             <span class="title">
                <?php echo $value['title']; ?>
             </span>
                <span class="icon">
                <i class="glyphicon glyphicon-calendar"></i><?php echo $value['date']; ?>
                    <i class="glyphicon glyphicon-user"></i> <a href=""><?php echo $value['author'] ?></a>
             </span>
                <div class="content">
                    <?php echo $value['content']; ?>
                </div>
                <div class="article-bottom">
                    <a href="detail?postId=<?php echo $value['ID']; ?>" target="_blank" class="label-click-1">
                        <button class="btn btn-info">继续阅读 <i class="glyphicon glyphicon-eye-open"></i></button>
                    </a>
                    <footer class="entry-footer">
                 <span class="cat-links">
                    <i class="fa fa-th-list"></i> <a href="catDetail?catId=<?php echo $value['catId']; ?>" rel="category tag " class="label-click"><?php echo $value['catename'] ?></a>
                    <br/>
                    <p>
                      <i class="fa fa-tags"></i>
                        <?php if($value){?>
                        <?php foreach ($value['tagnames']  as $v) {?>
                        <a href="tagDetail?tag=<?php echo $v['tagId'] ?>" class="label-click"> <span><?php echo $v['tagname']; ?></span></a>
                        <?php } ?>
                        <?php  } ?>
                    </p>
                 </span>
                    </footer>
                </div>
            </div>
            <?php } ?>
            <div class="more" id="honycyhMore-btn" data-type="tag" data-page="1" data-id="<?php echo $tagId;?>" >
                点击加载更多
            </div>
            <script>
                $('#honycyhMore').honycyhMore({
                    honycyhMoreBtn: '#honycyhMore-btn',
                    honycyhMoreBox: '#honycyhMore-box'
                })
            </script>

        </div>
      </div>
     <?php include  HOME.DS.'components'.DS.'aside.tpl'?>
   </div>
 </section>


<?php include HOME.DS.'components'.DS.'footer.tpl'?>


