
 $(function(){
  $.ajaxComment = function(api,data){
    return new Promise(function(resolve,reject){
     $.post(api,data,
      function(data,status){
            resolve(data);
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

