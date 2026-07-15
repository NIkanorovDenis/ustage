if (window){
    function bxrResizeRK_fs(){
        $('.rk-fullwidth-static').each(function(){
            rkWidth = $(this).children('.rk-fullwidth-canvas').find("img").width();
            if (rkWidth>0 && rkWidth>$(this).width()){
                rkWidth = Math.round((rkWidth-$(this).width())/2);
                $(this).children('.rk-fullwidth-canvas').css('margin-left', '-'+rkWidth+'px');
            }
            $(this).children('.rk-fullwidth-canvas').animate({'opacity':'1'}, 500);
        });
    };
    $(document).ready(function(){
        bxrResizeRK_fs();
    });
}