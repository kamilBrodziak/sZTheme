$( document ).ready( function() {
    let root = document.documentElement;
    root.style.setProperty("--deviceHeight",
        window.screen.availHeight - (window.outerHeight - window.innerHeight) + "px");
    let parallax = new ParallaxBgPicture($('.parallaxBg'));
    parallax.toggleParallax();
    let hdrNavbar = $("header");
    let lastScrollTop = hdrNavbar.offset().top;
    let stickyNav = function(){
        let scrollTop = $(window).scrollTop();
        if (scrollTop <= parseFloat(hdrNavbar.css("height"))) {
            hdrNavbar.removeClass(['stickyFade', 'stickyTransition']);
        } else if (lastScrollTop >= scrollTop || scrollTop <= parseFloat(hdrNavbar.css("height"))) {
            hdrNavbar.removeClass('stickyFade');
            hdrNavbar.addClass('stickyTransition');
        } else if(scrollTop > parseFloat(hdrNavbar.css("height")) ){
            hdrNavbar.addClass(['stickyFade', 'stickyTransition']);
        }
        lastScrollTop = scrollTop;
    };
    stickyNav();

    $(window).scroll(function() {
        stickyNav();
        console.log($(window).scrollTop());
    });
    let mobileNav = new MobileNav($("#hdrNavbarMobileButton"), $("#hdrNavbar"));

});

class ParallaxBgPicture {
    constructor(parallaxBgDOM) {
        this.parallaxBgDOM = parallaxBgDOM;
        this.parallaxBgInitialPosY = 0;
        // this.setBgHeight();
        this.adjustParallaxWhenBrowserResize();
    }

    // setBgHeight() {
    //     let parallaxBgThumbnailWidth = parseFloat(this.parallaxBgDOM.data("thumbnail-width"));
    //     let parallaxBgThumbnailHeight = parseFloat(this.parallaxBgDOM.data("thumbnail-height"));
    //     let parallaxBgContainerWidth = parseFloat(this.parallaxBgDOM.css('width'));
    //     this.parallaxBgDOM.css("height", parallaxBgContainerWidth * parallaxBgThumbnailHeight / parallaxBgThumbnailWidth);
    // }

    setParallaxBgPosY() {
        this.parallaxBgInitialPosY = parseFloat($("header").css('height'));
    }

    adjustParallaxWhenBrowserResize() {
        let self = this;
        $(window).resize(function() {
            self.setParallaxBgPosY();
            // self.setBgHeight();
            self.scrollParallax(parseFloat($(window).scrollTop()));
        });
    }

    toggleParallax() {
        let self = this;
        this.setParallaxBgPosY();
        this.scrollParallax($(window).scrollTop());
        $(window).scroll(function() {
            self.scrollParallax(this.scrollY);
        });
    }

    scrollParallax(scrollY) {
        let newBgPosY = this.parallaxBgInitialPosY - scrollY > 0 ? this.parallaxBgInitialPosY - scrollY : 0;
        this.parallaxBgDOM.css("background-position-y", newBgPosY);
    }
}


class MobileNav {
    constructor(mobileNavButton, navbar) {
        this.mobileNavButton = mobileNavButton;
        this.navbar = navbar;
        this.enableMobileNavbarButton();
        this.closeNavByClickEvent();
        this.closeNavWhenResizeEvent();
        this.closeNavWhenScrollEvent();
        this.changeNavMode();
    }

    closeNavByClickEvent() {
        let self = this;
        $(document).mouseup(function(e) {
            if (self.mobileNavButton.hasClass("changeMobileNavButtonState") && !self.mobileNavButton.is(e.target) &&
                !self.navbar.is(e.target) && self.navbar.has(e.target).length === 0) {
                    self.closeNav();
            }
        });
    }

    closeNavWhenResizeEvent() {
        let self = this;
        $(window).resize(function() {
            self.changeNavMode();
        });
    }

    closeNavWhenScrollEvent() {
        let self = this;
        $(window).scroll(function() {
            if(self.mobileNavButton.css("display") !== "none") {
                self.closeNav();
            }
        });
    }

    changeNavMode() {
        let self = this, doneCallback, promise;
        this.mobileNavButton.removeClass("changeMobileNavButtonState");
        if(this.mobileNavButton.css("display") === "none") {
            promise = () => {self.navbar.removeClass("hdrNavbarMobileTransition")};
            doneCallback = () => {self.navbar.css("width","100%")};
        } else {
            promise = () => {self.navbar.css("width", 0)};
            doneCallback = () => {self.navbar.addClass("hdrNavbarMobileTransition")};
        }
        $.when(promise()).then(doneCallback);
    }

    enableMobileNavbarButton() {
        let self = this;
        this.mobileNavButton.on("click", function() {
            if(parseFloat(self.navbar.css("width")) > 0) {
                self.closeNav();
            } else {
                self.openNav();
            }
        });
    }

    closeNav() {
        this.navbar.css("width", 0);
        this.mobileNavButton.removeClass("changeMobileNavButtonState");
    }

    openNav() {
        this.mobileNavButton.addClass("changeMobileNavButtonState");
        this.navbar.css("width", "70%");
    }
}
