(function() {
    if (!!window.JCPromoControllerSlider)
        return;

    window.JCPromoControllerSlider = function(params) {

        var _this = this;

        this.prevBtn;
        this.nextBtn;
        this.setButtons(params.hideDesktop, params.hideMobile);
        //this.setHeight(params.uniqId, params.break);
        var bReak =[];
        for (key in params.break) {
            var I = {
                breakpoint:params.break[key].point,
                settings:{
                    height:params.break[key].height
                }
            }
            bReak.push(I);
        }
        $('.bxr-slider#slider_'+params.uniqId).slick({
            dots: params.dots,
            infinite: params.infinite,
            speed: params.speed,
            autoplay: params.autoPlay,
            autoplaySpeed: params.autoPlaySpeed,
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: this.prevBtn,
            nextArrow: this.nextBtn,
            responsive: bReak

        });
        //$('.bxr-slider#slider_'+params.uniqId).css("visibility", "visible");
        $('.bxr-slider#slider_'+params.uniqId).on('breakpoint', function(event, slick, breakpoint){
            _this.setHeight(params.uniqId,params.break);
        });
    };
    window.JCPromoControllerSlider.prototype =
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
            },
            setHeight:function(uid,params){

                var D = {}, I = [];
                for (key in params) {
                    if (window.matchMedia("(min-width: "+ params[key].point +"px)").matches) {
                        D[params[key].point] = key;
                        I.push(params[key].point);
                    }
                }
                if(I.length > 0) {
                    I = D[Math.max.apply(null, I)];
                    if (params[I].hidden != "Y") {
                        $('.bxr-slider#slider_' + uid).css("height", params[I].height)
                        $('.bxr-slider#slider_' + uid).show();
                    } else {
                        $('.bxr-slider#slider_' + uid).hide();
                    }
                }
            }
        }
})();