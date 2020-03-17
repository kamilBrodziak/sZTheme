jQuery( document ).ready( function( $ ) {
    let root = document.documentElement;
    root.style.setProperty("--deviceHeight", window.screen.height * window.devicePixelRatio + "px");
    let hdrNavbar = $("header");
    let isReload = true;
    console.log(window.innerWidth);
    let lastScrollTop = hdrNavbar.offset().top;
    let stickyNav = function(){
        let scrollTop = $(window).scrollTop();
        if (scrollTop <= parseInt(hdrNavbar.css("height"))) {
            hdrNavbar.removeClass('stickyTransition');
            hdrNavbar.removeClass('stickyFade');
        } else if (lastScrollTop >= scrollTop || scrollTop <= parseInt(hdrNavbar.css("height"))) {
            hdrNavbar.removeClass('stickyFade');
            hdrNavbar.addClass('stickyTransition');
        } else if(scrollTop > parseInt(hdrNavbar.css("height")) ){
            hdrNavbar.addClass('stickyFade');
            hdrNavbar.addClass('stickyTransition');
        }
        lastScrollTop = scrollTop;
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
function parallax() {
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



$(document).mouseup(function(e)
{
    let hdrNavbar = $("#hdrNavbar");
    let hdrNavbarMobile = $("#hdrNavbarMobileButton");
    if (hdrNavbarMobile.hasClass("changeMobileNavButtonState") && !hdrNavbar.is(e.target) && hdrNavbar.has(e.target).length === 0)
    {
        hdrNavbar.css("width", 0);
        let hdrNavbarMobile = $("#hdrNavbarMobileButton");
        hdrNavbarMobile.removeClass("changeMobileNavButtonState")
    }
});

$(window).resize(function() {
    let hdrNavbarMobile = $("#hdrNavbarMobileButton");
    let hdrNavbar = $("#hdrNavbar");
    if(hdrNavbarMobile.css("display") === "none") {
        hdrNavbarMobile.removeClass("changeMobileNavButtonState");
        $.when(hdrNavbar.removeClass("hdrNavbarMobileTransition")).then(function() {
            hdrNavbar.css("width", "100%");
        })
    } else {
        $.when(hdrNavbar.css("width", "0px")).then(function() {
            hdrNavbar.addClass("hdrNavbarMobileTransition");
        })
    }
});

function closeOrOpenNav() {
    let hdrNavbar = $("#hdrNavbar");
    let hdrNavbarMobile = $("#hdrNavbarMobileButton");
    if(parseInt(hdrNavbar.css("width")) > 0) {
        hdrNavbar.css("width", "0px");
        hdrNavbarMobile.removeClass("changeMobileNavButtonState");
    } else {
        hdrNavbarMobile.addClass("changeMobileNavButtonState");
        hdrNavbar.css("width", "70%");
    }
}
