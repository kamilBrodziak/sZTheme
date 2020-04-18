$( document ).ready( function() {
    let root = document.documentElement;
    root.style.setProperty("--deviceHeight",
        window.screen.availHeight - (window.outerHeight - window.innerHeight) + "px");
    let parallax = new ParallaxBgPicture($('.parallaxBg'));
    parallax.toggleParallax();
    let mobileNav = new MobileNav($("#hdrNavbarMobileButton"), $("#hdrNavbar"), $("#siteHeader"));
    mobileNav.addHeaderFade();
    let contactForm = $('.contactForm');
    contactForm.on('submit', function (e) {
        e.preventDefault();
        let form = $(this),
            name = form.find('#name').val(),
            email = form.find('#email').val(),
            message = form.find('#message').val(),
            ajaxUrl = form.data('url');
        console.log(message);
        if(name == '' || email == '' || message == '') {
            console.log('required inputs are empty');
            return;
        }

        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                name: name,
                email: email,
                message: message,
                action: 'sendUserEmail'
            },
            error: function (response) {
                console.log(response);
            },
            success: function (response) {
                console.log(response);

            }
        });

        form.find(".contactFormSuccessInfo").addClass("contactFormSuccessInfoDisplay");
        setTimeout(function() {
            form.find(".contactFormSuccessInfo").removeClass("contactFormSuccessInfoDisplay");
        }, 2000);
    });
    
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
    constructor(mobileNavButton, navbar, header) {
        this.mobileNavButton = mobileNavButton;
        this.navbar = navbar;
        this.header = header;
        this.lastScrollTop = header.offset().top;
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

    // let lastScrollTop = hdrNavbar.offset().top;
    headerFade() {
        let scrollTop = $(window).scrollTop();
        if (scrollTop <= parseFloat(this.header.css("height"))) {
            this.header.removeClass(['stickyFade', 'stickyTransition']);
        } else if (this.lastScrollTop >= scrollTop || scrollTop <= parseFloat(this.header.css("height"))) {
            this.header.removeClass('stickyFade');
            this.header.addClass('stickyTransition');
        } else if(scrollTop > parseFloat(this.header.css("height")) ){
            this.header.addClass(['stickyFade', 'stickyTransition']);
        }
        this.lastScrollTop = scrollTop;
    };

    addHeaderFade() {
        this.headerFade();
        let self = this;
        $(window).scroll(function() {
            self.headerFade();
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
