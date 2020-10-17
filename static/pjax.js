$('body').delegate('.label-click', 'click', function (e) {
    handlePage($(this).attr('href'));
    e.preventDefault();
})
$(window).bind('popstate', function (e) {
    handlePage(e.originalEvent.state.count);
})
$.pageCache = {};


function handlePage(href) {
    // if ($.pageCache[href]) {
    //     //     history.pushState({count: href}, null, href);
    //     //     $('.pjax').html($.pageCache[href]);
    //     // } else {
    //     //
    //     // }
    $.ajax({
        "url": '/index.php/pjax/' + href,
        "dataType": "html",
        "headers": {
            "X_PJAX": true
        },
        success: function (data, status) {
            let $datadiv = $(data).find("#content");
            let d = $(data).clone();
            $datadiv.length > 0 && (
                $(d).find("#content").html(marked($(data).find('#blog').val()))
            );
            $('.pjax').html(d);
            $.pageCache[href] = d;
            history.pushState({count: href}, null, href);
        }
    });
    $(document).scrollTop() > 30 && $('#Totop').trigger('click');
}

$(function () {
    console.log($.cookie('body-dark') == 'false')
    if ($.cookie('body-dark') == 'true') {
        $(this).addClass('fa-moon-o');

        $(document.body).addClass('body-dark');
    } else {
        $(this).removeClass('fa-moon-o');

        $(document.body).removeClass('body-dark');
    }
    $('#nav').affix({
        offset: {
            top: 330,
            bottom: function () {
                return (this.bottom = $('.footer').outerHeight(true))
            }
        }
    })

    $('#theme>button').eq(0).click(function () {
        $(this).toggleClass('fa-moon-o');
        $(document.body).toggleClass('body-dark');
        $.cookie('body-dark', $(document.body).hasClass('body-dark'), {expires: 7});
    });
});

