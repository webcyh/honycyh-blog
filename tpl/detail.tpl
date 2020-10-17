<div id="detailcontent">

          <div >
             <div>
              <div class="info">
                 <span>Time:<?php echo $detail['date']; ?></span>
              </div>
              <div style="padding-top:30px" class="content" id="content">
                 <textarea id="blog"><?php echo $detail['content']; ?></textarea>
              
              </div>
           </div>
          </div>
         <div>
       <div id="comment">
            <div class="allcomments" id="allcomments">
              <!-- 一条评论 -->
                <?php if ($detail['comments']): ?>
                  <?php foreach ($detail['comments'] as $k => $val): ?>
                    <div class="replay">
                      <ul>
                        <li>
                          <div class="avater">
                            <img src="<?php echo $val['thumb_img']; ?>" alt=""></div>
                            <div class="info"> 
                              <h5><a href="标题"><?php echo $val['nickname']; ?></a></h5>
                              <p><?php echo date('Y-m-d H:i:s',$val['create_time']) ?></p>
                            </div>
                 <!--           <a class="bth-reply" data-id="<?php echo $val['id']; ?>" data-name="<?php echo $val['nickname']; ?>" data-level="1" data-toele="#Id<?php echo $val['id']; ?>">回复</a>-->
                        </li>
                        <li><?php echo $val['content']; ?></li>
                        <li id="#Id<?php echo $val['id']; ?>"></li>
                      </ul>
                    </div>
                  <?php endforeach ?>
                <?php endif ?>
               <form data-url="" novalidate="novalidate" data-toPost="<?php echo $detail['ID'];?>">
              <div class="col-md-12">
                 <a class="btn btn-default btn-sm" style="visibility: hidden;" id="reply">取消回复</a>
              </div>
              <div class="col-md-4">
                 <input type="text" name="name" required placeholder="称呼" aria-required="true" class="valid">
              </div>
              <div class="col-md-4">
                 <input type="email" name="email" required placeholder="邮箱" aria-required="true" class="valid">
              </div>
              <div class="col-md-4">
                  <input type="url" name="url" placeholder="http://" class="valid">
              </div>
              <div>
                <textarea placeholder="" required aria-required="true"></textarea>
              </div>
               <footer>
                <button type="button">
                  OωO表情
                </button>
                <button type="submit" data-api="/index.php/api/comment" toele="#allcomments">
                  提交评论
                </button>
              </footer>
            </form>
            </div>
         </div>
       </div>
     </div>
  </div>
<!--<script type="text/javascript" src="/static/comment.js"></script>
-->
<script>

 $(function(){
  $.ajaxComment = function(api,data){
    return new Promise(function(resolve,reject){
     $.post(api,data,
      function(data,status){
           data.status==1&&resolve(data);
      });
    })
  }

  let $form = $('[data-url]');
  let $textarea  = $('[data-url] textarea');
  let $button = $form.find('button[data-api]');
  $('#reply').click(function(){
    $('#allcomments').before($form);
    $(this).css('visibility','hidden');
    $button.data({
      'api':'index.php/api/comment'
    });
    $button.attr('toele','#allcomments');
  })
 $('#comment').delegate('.bth-reply','click',function(){
  $('#reply').css('visibility','visible');
   $(this).parent().parent().after($form);
    $button.data({
      'api':'index.php/api/reply',
      'level':$(this).data('level'),
      'name':$(this).data('name')
    });
   $button.attr('toele',$(this).data('toele'));
   $(this).data('level') == 2&&$button.data('replyId',$(this).data('replyId'));
   $textarea.attr('placeholder','@'+$(this).data('name'));
 })
 $button.click(function(){
 	let $this = $(this);
 	let $toEle = $this.attr('toele');
   $("[data-url]").validate({
    submitHandler: function(form){ 
       let data = {};
       $form = $('[data-url]');
        if($toEle!='#allcomments'){
           data.comment_id = $form.data('topost');
           data.reply_id = $form.find('[name=name]').val();
           data.from_nickname = $form.find('[name=name]').val();
           data.to_nickname = $form.find('[name=email]').val();
        }else{
           data.topic_id = $form.data('topost');
           data.nickname = $form.find('[name=name]').val();
        }
         data.content = $form.find('textarea').val();
         data.email = $form.find('[name=email]').val();
         $.ajaxComment($button.data('api'),data).then((data2)=>{
          $($toEle).append(`<div class="replay">
              <ul>
                <li>
                  <div class="avater">
                    <img src="/static/blog-logo.jpg" alt=""></div>
                    <div class="info"> 
                      <h5><a href="标题">${data2.nickname}</a></h5>
                      <p>2020 年 03 月 25 日 16:05</p>
                    </div>
                    <a class="bth-reply" data-id="5" data-name="${data2.nickname}" data-toele="#Id1">回复</a>
                </li>
                <li>${data2.content}</li>
              </ul>
            </div>`);
         })
      } 
   });
 })
})

</script>
