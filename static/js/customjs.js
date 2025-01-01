jQuery.noConflict();
var $ = jQuery;

$(document).ready(function() {
    $(".menu-link, .close-menu").on("click",
        function() {
            $("#wrap").toggleClass("menu-open");
            $("#menu").toggleClass("menuon");
            return false
        });


    $('.menu-item-has-children').click(function(){
        $(this).addClass('toggled');
        if($('.menu-item-has-children').hasClass('toggled'))
        {
            $(this).children('ul').toggle();
        }
        $(this).toggleClass('toggle');
        return false;
    });
    $('.menu-item-has-children a').click(function(event){
        location.href = this.href;
    });


    $(".dropdown").mouseover(function() {
        $(this).addClass("open")
    }).mouseout(function() {
        $(this).removeClass("open")
    });

    $(".menu-cart-wrap").mouseover(function() {
        $(".menu-cart").css("display","block")
    }).mouseout(function() {
        $(".menu-cart").css("display","none")
    });
    $(".product-cart-wrap").mouseover(function() {
        $(".product-cart").css("display","block")
    }).mouseout(function() {
        $(".product-cart").css("display","none")
    });

});


$(document).ready(function() {
    $("#clicksearch").click(function() {
        $("#clicksearch").toggleClass("active")
    });
    $("html, body").on("click",
        function(e) {
            if (!$(e.target).hasClass("not-click")) {
                $("#clicksearch").removeClass("active")
            }
        })
});

////back to top
$(document).ready(function() {
    $("#back-to-top").hide();
    $(function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 100) {
                $("#back-to-top").fadeIn(1500)
            } else {
                $("#back-to-top").fadeOut(1500)
            }
        });
        $("#back-to-top").click(function() {
            $("body,html").animate({
                    scrollTop: 0
                },
                1000);
            return false
        })
    })
});


$(document).ready(function() {
    ///product categories
    $('.cat-parent').click(function(){
        $(this).addClass('toggled');
        if($('.cat-parent').hasClass('toggled'))
        {
            $(this).children('ul').toggle();
        }
        $(this).toggleClass('toggle');
        return false;
    });
    $('.cat-parent a').click(function(event){
        location.href = this.href;
    });
});



//// sticky sidebar
$(document).ready(function() {
    $('.sidebar,.sidebar-sticker,.sidebarleft,.post-wrapper,.post-sticker,.category-wrap,.content1-sticker,.content2-sticker,.content3-sticker')
        .daxStickySidebar({
            additionalMarginTop: 52
        });
});


