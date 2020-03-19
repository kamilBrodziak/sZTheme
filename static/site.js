jQuery( document ).ready( function( $ ) {
    let root = document.documentElement;
    root.style.setProperty("--deviceHeight", window.screen.height * window.devicePixelRatio + "px");
    let hdrNavbar = $("header");
    let isReload = true;
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
            isReload = false;
        }
    });

    $(window).resize(function() {
        setParallaxBackgroundPosY();
        setArticleHeaderHeight();
    });
    parallax($(window).scrollTop());
    enableMobileNavbar();
});

let parallaxBg = $('.parallaxBg');
let parallaxBackgroundInitialPosY = parseInt(parallaxBg.css("background-position-y")) + parseInt($(".header").css('height'));

function setArticleHeaderHeight() {
    let parallaxBgHeight = parseInt(parseInt(parallaxBg.css('width')) * parallaxBg.data("thumbnail-height") /
        parallaxBg.data("thumbnail-width"));
    parallaxBg.css("height", parallaxBgHeight);
}

setArticleHeaderHeight();
function parallax(reloadScrollTop) {

    let wScroll = reloadScrollTop ? reloadScrollTop : $(window).scrollTop();
    if(parallaxBackgroundInitialPosY - wScroll > 0) {
        parallaxBg.css("background-position-y", parallaxBackgroundInitialPosY - wScroll);
    } else {
        parallaxBg.css("background-position-y", 0);
    }
}
parallax();

function setParallaxBackgroundPosY() {
    parallaxBackgroundInitialPosY = parseInt($(".header").css('height'));
    parallax();
}

let hdrNavbar = $("#hdrNavbar");
let hdrNavbarMobile = $("#hdrNavbarMobileButton");


$(document).mouseup(function(e) {
    if (hdrNavbarMobile.hasClass("changeMobileNavButtonState") && !hdrNavbar.is(e.target) && hdrNavbar.has(e.target).length === 0)
    {
        hdrNavbar.css("width", 0);
        hdrNavbarMobile.removeClass("changeMobileNavButtonState")
    }
});

$(window).scroll(function() {
   closeNav();
});

$(window).resize(function() {
    closeNav();
});

function enableMobileNavbar() {
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
}

$(window).resize(function() {
    enableMobileNavbar();
});

function closeOrOpenNav() {
    if(parseInt(hdrNavbar.css("width")) > 0) {
        closeNav();
    } else {
        openNav();
    }
}


function closeNav() {
    hdrNavbar.css("width", "0px");
    hdrNavbarMobile.removeClass("changeMobileNavButtonState");
}

function openNav() {
    hdrNavbarMobile.addClass("changeMobileNavButtonState");
    hdrNavbar.css("width", "70%");
}
