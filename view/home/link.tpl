<?php include HOME.DS.'components'.DS.'header.tpl'?>
<a  href="<?php echo $infoArr['github地址']['info_value']?>" class="git-link hidden-xs"></a>
 <!--#导航栏-->
 <section id="main" class="container">
   <div class="row">
      <div class="col-md-8 col-md-push-1 pjax">
      	<!--我的学习历程-->
		 <ul class="layui-timeline" >
		 <?php foreach ($link as $key => $value) {  ?>
		    <li class="layui-timeline-item">
		      <i class="fa fa-clock-o"></i>
		      <div class="layui-timeline-content layui-text">
		        <h3 class="layui-timeline-title"><?php echo $value['link_title'] ?></h3>
		        <p>
		          <?php echo $value['link_des'] ?>
		       <a href="<?php $value['link_url'] ?>" data-toggle="tooltip" data-placement="right" title="转向kiwipeach's blog"> <i style="font-size:24px" class="fa">&#xf0c1</i></a>
		        </p>
		      </div>
		    </li>
		 <?php } ?>
		</ul>
 <!--#我的学习历程-->
      </div>
        <?php include HOME.DS.'components'.DS.'aside.tpl'?>
      <!--#右侧内容区-->
   </div>
 </section>
<?php include HOME.DS.'components'.DS.'footer.tpl'?>