jQuery( document ).ready( function( $ ) {
    let hdrNavbar = $('#hdrNavbar');
    let stickyNavTop = hdrNavbar.offset().top;
    let isReload = true;
    let stickyNav = function(){
        let scrollTop = $(window).scrollTop();
        if (scrollTop > stickyNavTop) {
            hdrNavbar.addClass('sticky');
        } else {
            hdrNavbar.removeClass('sticky');
        }
    };
    stickyNav();

    $(window).scroll(function() {
        stickyNav();
        if(!isReload) {
            parallax();
        } else {
            isReload=false;
        }
    });

    $(window).resize(function() {
        setParallaxBackgroundPosY();
        setArticleHeaderHeight();
    });
});

let parallaxBg = $('.parallaxBg');
let parallaxBackgroundInitialPosY = parseInt(parallaxBg.css("background-position-y")) + parseInt($(".header").css('height'));

function setArticleHeaderHeight() {
    let parallaxBgHeight = parseInt(parseInt(parallaxBg.css('width')) * parallaxBg.data("thumbnail-height") /
        parallaxBg.data("thumbnail-width"));
    parallaxBg.css("height", parallaxBgHeight);
}

setArticleHeaderHeight();
function parallax(isReload) {
    let wScroll = $(window).scrollTop();
    if(parallaxBackgroundInitialPosY - wScroll > 0) {
        parallaxBg.css("background-position-y", parallaxBackgroundInitialPosY - wScroll);
    } else {
        parallaxBg.css("background-position-y", 0);
    }
    window.scrollTo(0, wScroll);
}
parallax();
function setParallaxBackgroundPosY() {
    parallaxBackgroundInitialPosY = parseInt($(".header").css('height'));
    parallax();
}
