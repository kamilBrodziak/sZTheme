jQuery( document ).ready( function( $ ) {


    let hdrNavbar = $("header");
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
    });
    enableMobileNavbar();
});

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
    if(hdrNavbarMobile.css("display") !== "none") {
        closeNav();
    }
});

$(window).resize(function() {
    if(hdrNavbarMobile.css("display") !== "none") {
        closeNav();
    }
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

window.onload = function() {
    let root = document.documentElement;
    root.style.setProperty("--deviceHeight",
        window.screen.availHeight - (window.outerHeight - window.innerHeight) + "px");
    let parallax = new ParallaxBgPicture($('.parallaxBg'));
}

class ParallaxBgPicture {
    constructor(parallaxBgDOM) {
        this.parallaxBgDOM = parallaxBgDOM;
        this.parallaxBgInitialPosY = 0;
        this.setBgHeight();
        this.setParallaxBgPosY();
        this.adjustParallaxWhenBrowserResize();
        this.toggleParallax();
        this.scrollParallax();
    }

    setBgHeight() {
        let parallaxBgThumbnailWidth = parseFloat(this.parallaxBgDOM.data("thumbnail-width"));
        let parallaxBgThumbnailHeight = parseFloat(this.parallaxBgDOM.data("thumbnail-height"));
        let parallaxBgContainerWidth = parseFloat(this.parallaxBgDOM.css('width'));
        this.parallaxBgDOM.css("height", parallaxBgContainerWidth * parallaxBgThumbnailHeight / parallaxBgThumbnailWidth);
    }

    setParallaxBgPosY() {
        this.parallaxBgInitialPosY = parseFloat($(".header").css('height'));
    }

    adjustParallaxWhenBrowserResize() {
        let self = this;
        $(window).resize(function() {
            self.setParallaxBgPosY();
            self.setBgHeight();
            self.scrollParallax();
        });
    }

    toggleParallax() {
        let self = this;

        $(window).scroll(function() {
            self.setParallaxBgPosY();
            self.scrollParallax();
        });
    }

    scrollParallax() {
        let wScroll = parseFloat($(window).scrollTop());
        let newBgPosY = this.parallaxBgInitialPosY - wScroll > 0 ? this.parallaxBgInitialPosY - wScroll : 0;
        this.parallaxBgDOM.css("background-position-y", newBgPosY);
    }

}
