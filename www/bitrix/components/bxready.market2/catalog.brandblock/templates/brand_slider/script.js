(function() {
    if (!!window.JCCatalogBrandSlider)
        return;

    window.JCCatalogBrandSlider = function(params) {
        this.prevBtn;
        this.nextBtn;
        this.setButtons(params.hideDesktop, params.hideMobile);
        BXReady.showAjaxShadow('#sl_'+params.uniqId, 'shadow_slider_'+params.uniqId);
        $('#sl_'+params.uniqId).slick({
            dots: params.dots,
            infinite: false,
            speed: params.speed,
            slidesToShow: params.XLG_CNT,
            slidesToScroll: 1,
            prevArrow: this.prevBtn,
            nextArrow: this.nextBtn,
            lazyLoad: 'ondemand',
            responsive: [
                {
                    breakpoint: params.LG_BREAKPOINT,
                    settings: {
                        slidesToShow: params.LG_CNT,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: params.MD_BREAKPOINT,
                    settings: {
                        slidesToShow: params.MD_CNT,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: params.SM_BREAKPOINT,
                    settings: {
                        slidesToShow: params.SM_CNT,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: params.XS_BREAKPOINT,
                    settings: {
                        slidesToShow: params.XS_CNT,
                        slidesToScroll: 1
                    }
                },
            ]
        });
        $('.bxr-slick-section').css({'height': 'auto'});
        BXReady.closeAjaxShadow('shadow_slider_'+params.uniqId);
    };

    window.JCCatalogBrandSlider.prototype =
        {
            isTouchDevice: function() {
                try {
                    document.createEvent('TouchEvent');
                    return true;
                }
                catch(e) {
                    return false;
                }
            },

            setButtons: function(hideDesktop, hideMobile)
            {
                isTouch = this.isTouchDevice();
                addClass = (!isTouch && hideDesktop || isTouch && hideMobile) ? " hidden-arrow" : "";
                this.prevBtn = '<button type="button" class="bxr-color-button slick-prev '+ addClass +'"></button>';
                this.nextBtn = '<button type="button" class="bxr-color-button slick-next '+ addClass +'"></button>';
            }
        }
})();