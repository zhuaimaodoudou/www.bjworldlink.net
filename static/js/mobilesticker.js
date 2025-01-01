
jQuery.noConflict();
var $ = jQuery;
$(window).scroll(function(){
    var scroll_top = $(document).scrollTop();
    if(scroll_top <90 ){

        $('.header-mobile').removeClass('stickermobile');



    }else{

        $('.header-mobile').addClass('stickermobile');


    }

});

$(document).ready(function(){
    var scroll_top = $(document).scrollTop();
    if(scroll_top >90 ){
        $('.header-mobile').addClass('stickermobile');

    }
});