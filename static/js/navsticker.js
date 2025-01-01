
jQuery.noConflict();
var $ = jQuery;
$(window).scroll(function(){
    var scroll_top = $(document).scrollTop();
    if(scroll_top >535 ){
        $('.sticker').css('display','block');
        $('.navbar').css('display','none');
    }else{
        var scroll_top = $(document).scrollTop();
        if(scroll_top <230 ){
            $('.sticker').css('display','none');
            $('.navbar').css('display','block');
        }

    }});