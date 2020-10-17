$(function () {
    $('#nav').affix({
        offset: {
            top: 330,
            bottom: function () {
                return (this.bottom = $('.footer').outerHeight(true))
            }
        }
    })


    let top = true;
    $('#Totop').click(function () {
        if (top) $('html,body').animate({scrollTop: '0px'}, 800, () => {
            top = true;
        });
        top = false;
    })

    $(document).scroll(function () {
        var height = $(this).height() * (1 / 8);
        var _this = $(this);
        if ($(this).scrollTop() > height) {
            $('#Totop').css({
                right: '20px'
            })
        } else {
            $('#Totop').css({
                right: '-100px'
            })
        }
    })
})
