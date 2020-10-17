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