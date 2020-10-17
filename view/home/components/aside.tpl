<div class="col-md-3 col-md-push-1" id="aside">
    
    <!--#用户登录注册信息区-->
    <!--关注-->
    <!--分类目录-->
    <aside class="cate"> <span><h4>分类目录</h4></span>
        <?php foreach ($category as $key => $value) {?>
            <p><a class="label-click" href="catDetail?catId=<?php echo $value['ID'] ?>"><?php echo $value['catName']; ?></a></p>
        <?php }?>
    </aside>

     <!--展示标签-->
    <aside class="tag">
         <span><h4>标签云</h4></span>
        <!--根据标签找到相应的文章-->
        <?php foreach ($tags as $key => $value) {?>
            <a href="tagDetail?tag=<?php echo $value['tagId'] ?>" class="label-click label label-default">
                <?php echo $value['tagname'] ?>
                <span><?php echo $value['postnum'] ?></span>
            </a>
        <?php } ?>
    </aside>
</div>
