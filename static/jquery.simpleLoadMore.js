/**
 * 实现一个可复用的点击加载pjax实现的插件
 * 配置对象：点击按钮（默认为#honycyhMore-btn） 是否为异步方式 获取到后追加的位置 （默认为#honycyhMore-box）
 * 编写为绑定在某个元素上面（默认为#honycyhMore）
 */


(function ($) {
    $.fn.honycyhMore = function (options) {
        //获取指定的绑定源
        var settings = $.extend({
            honycyhMoreBtn: '#honycyhMore-btn',
            honycyhMoreBox: '#honycyhMore-box'
        }, options);
        var $honycyhMore = $(this);
        var $honycyhMoreBtn = $(settings.honycyhMoreBtn) ? $(settings.honycyhMoreBtn) : $('<a href="#" class="honycyhMoreBtn">View More <i class="fas fa-angle-down"></i></a>');
        let $honycyhMoreBox = $(settings.honycyhMoreBox);
        //如果没有指定按钮将自动追加
        if (!$honycyhMore.find('#honycyhMore-btn')) {
            $thisLoadMore.append(honycyhMoreBtn);
        }

        $honycyhMoreBtn.on('click', function (e) {
            let {id,page,type} = $(this).data();
            let $this = $(this);
            let url = type=='tag'?'tagDetailMore?tagId':'catDetailMore?catId';
            $.ajax({
                "url": `/index.php/pjax/${url}=${id}&page=${page}`,
                "dataType": "html",
                "headers": {
                    "X_PJAX": true
                },
                success: function (data, status) {
                   if(!data) {
                       $this.text('没有数据了~~');
                       setInterval(()=>{
                           $this.remove();
                       },1000)
                   }else{
                       $this.data('page',page+1);
                       $this.before(data);
                   }
                }
            });
        });
    }
}(jQuery));
