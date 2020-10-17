<?php include HOME.DS.'components'.DS.'header.tpl' ?>


<main class="container" id="main">
   <div class="row">
      <div class="col-md-8  col-md-push-1 pjax">
       <!--写文章-->
        <?php foreach ($posts as $key => $value) { ?>
            <div class="article">
               <span class="title">
                  <?php echo $value['title']; ?>
               </span>
               <span class="icon">
                  <i class="glyphicon glyphicon-calendar"></i><?php echo $value['date']; ?>
               </span>
               <div class="content">
                 <?php echo $value['content']; ?>
               </div>
               <div class="article-bottom">
                 <a href="detail?postId=<?php echo $value['ID']; ?>" class="label-click-1" target="_blank">
                     <button class="btn btn-info" >继续阅读 <i class="glyphicon glyphicon-eye-open"></i></button>
                 </a>
                <footer class="entry-footer">
                   <span class="cat-links">
                      <i class="fa fa-th-list"></i> <a href="catDetail?catId=<?php echo $value['catId'] ?>" class="label-click" rel="category tag"><?php echo isset($value['catename'])?$value['catename']:'未分类' ?></a> 
                      <br/>
                      <p>
                        <i class="fa fa-tags"></i>
                        <?php if($value){?>
                          <?php foreach ($value['tagnames']  as $v) {?>
                                <a href="tagDetail?tag=<?php echo $v['tagId'] ?>" class="label-click"> <span>
                                  <?php echo $v['tagname']; ?></span>
                                </a>
                          <?php } ?>
                        <?php } ?>
                      </p>
                   </span>
                </footer>
               </div>
         </div>
        <?php } ?>
      </div>
     <?php include  HOME.DS.'components'.DS.'aside.tpl'?>
   </div>
</main>
<?php include HOME.DS.'components'.DS.'footer.tpl'?>


