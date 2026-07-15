(function(){

    jQuery.extend( jQuery.easing,
    {
        easeOutBounce: function (x, t, b, c, d) {
            if ((t/=d) < (1/2.75)) {
                return c*(7.5625*t*t) + b;
            } else if (t < (2/2.75)) {
                return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
            } else if (t < (2.5/2.75)) {
                return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
            } else {
                return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
            }
        },
        easeOutElastic: function (x, t, b, c, d) {
            var s=1.70158;var p=0;var a=c;
            if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
            if (a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
        },
        easeOutExpo: function (x, t, b, c, d) {
            return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
        }
    });

    BXReadyMenu = {

        menuWidth: 240,
        menuLeft: "100%",
        state: 'close',

        resize: function(){
            BXReadyMenu.menuLeft = "100%";
            $('#bxr-multilevel-menu').width(BXReadyMenu.menuLeft);
            $('.bxr-mobile-push-menu-content').width(BXReadyMenu.menuLeft);
            $('.bxr-mobile-push-menu #bxr-mobile-menu-body').width(BXReadyMenu.menuLeft);

        },

        init: function(){

            BXReadyMenu.resize();


            $('.bxr-mobile-push-menu-content').height($(document).height());

            $('.bxr-mobile-push-menu ul').height($(document).height()).width(BXReadyMenu.menuLeft);
            $('.bxr-mobile-push-menu-content').css('margin-left', '-954px');
        },

        showChildren: function (parentId){

            menuItem = $('li.content-child[data-parent='+parentId+']');
            //menuItem.css({'position':'absolute','left':'100%','top':'0', 'display': 'block', 'z-index':5});
            menuItem.css({'position':'absolute','left':'100%','top':'0', 'display': 'block', 'z-index':5});
            menuItem.animate({'left':'0'}, 200, 'easeOutExpo');
            $('html, body').animate({scrollTop:0}, 'slow');
        },

        closeChildren: function (parentId){
            menuItem = $('li.content-child[data-parent='+parentId+']');
            //menuItem.css.css({'z-index':0, 'left':'100%'});
            menuItem.css({'left':'0'});
            menuItem.animate({'left':'100%'}, 200, function(){
                menuItem.css({'display': 'none'});
            });
        },

        openMenu: function(){

            BXReadyMenu.init();

            $('.bxr-mobile-push-menu-content').animate({'margin-left': '0px'}, 300, 'easeOutExpo');
            c = $('.bxr-mobile-push-menu-v2');
            c.find('.bxr-mobile-menu-button-menu').addClass(c.attr('data-hoverClass')).data("show", "Y");;

            BXReadyMenu.state = 'open';
            BXReadyMenu.closeSlides('pull');
        },

        closeMenu: function(){

            $('.bxr-mobile-push-menu-content').animate({'margin-left':'-954px'}, 300, 'easeOutExpo', function(){
                $('html').removeClass('bxr-mobile-menu-content');
                $('html').css({'width':'auto'});
                c = $('.bxr-mobile-push-menu-v2');
                c.find('.bxr-mobile-menu-button-menu').removeClass(c.attr('data-hoverClass')).data("show", "N");;
            });

            BXReadyMenu.state = 'close';

        },

        closeSlides: function(elementID){
            $('.bxr-mobile-slide').each(function(){
                if ($(this).attr('id') != elementID){
                    $(this).slideUp(100);
                }
            });

            if (elementID != 'pull'){
                BXReadyMenu.closeMenu();
            }

        },

        activateButton: function(button){

            target = $(button).data('target');
            c = $('.bxr-mobile-push-menu-v2');
            c.find('.bxr-mobile-push-menu-button > li').each(function(){
                if ($(this).data('target') != target){
                    $(this).removeClass('bxr-mobile-menu-button-active');
                    if (!$(this).hasClass('bxr-mobile-menu-button-close'))
                        $(this).removeClass(c.attr('data-hoverClass'));
                }
            });

            if ($(button).hasClass('bxr-mobile-menu-button-active')){
                $(button).removeClass('bxr-mobile-menu-button-active');
                $(button).removeClass(c.attr('data-hoverClass'));
            }else{
                $(button).addClass('bxr-mobile-menu-button-active');
                $(button).addClass(c.attr('data-hoverClass'));
            }
        }
    }

    $(document).ready(function(){

        $(document).on(
            'refreshBasket',
            function(e, data) {

                if (!$('.bxr-mobile-menu-button-basket').is('.bxr-mobile-basket-indicator')) {
                    $('.bxr-mobile-menu-button-basket').append('<div class="bxr-mobile-basket-indicator basket-items-cnt bxr-color"></div>')
                };
                $('.bxr-mobile-menu-button-basket .bxr-mobile-basket-indicator').html(data.basket);
                if (data.basket < 1 ) {
                    $('.bxr-mobile-menu-button-basket .bxr-mobile-basket-indicator').css('display', 'none');
                } else {
                    $('.bxr-mobile-menu-button-basket .bxr-mobile-basket-indicator').css('display', 'block');
                }

                if (!$('.bxr-mobile-menu-button-heart').is('.bxr-mobile-favor-indicator')) {
                    $('.bxr-mobile-menu-button-heart').append('<div class="bxr-mobile-favor-indicator basket-items-cnt bxr-color"></div>')
                };
                $('.bxr-mobile-menu-button-heart .bxr-mobile-favor-indicator').html(data.favor);
                if (data.favor < 1 ) {
                    $('.bxr-mobile-menu-button-heart .bxr-mobile-favor-indicator').css('display', 'none');
                } else {
                    $('.bxr-mobile-menu-button-heart .bxr-mobile-favor-indicator').css('display', 'block');
                }
            }
        );

        $(document).on(
            'refreshCompare',
            function(e, data) {
                if (typeof(data) == 'object') {
                    var cntCompare = parseInt(Object.keys(data).length);
                    if (!$('.bxr-mobile-menu-button-chart').is('.bxr-mobile-compare-indicator')) {
                        $('.bxr-mobile-menu-button-chart').append('<div class="bxr-mobile-compare-indicator basket-items-cnt bxr-color"></div>')
                    };
                    $('.bxr-mobile-menu-button-chart .bxr-mobile-compare-indicator').html(cntCompare);
                    if (data.favor < 1 ) {
                        $('.bxr-mobile-menu-button-chart .bxr-mobile-compare-indicator').css('display', 'none');
                    } else {
                        $('.bxr-mobile-menu-button-chart .bxr-mobile-compare-indicator').css('display', 'block');
                    }
                }
            }
        );

        $(document).on(
            'click',
            '.bxr-mobile-push-menu-v2 .bxr-mobile-push-menu-button>li',
            function(){
                if($(this).data("target")=="menu"){
                    if($(this).data("show")=="N") {
                        BXReadyMenu.openMenu();
                        $(this).data("show", "Y");
                    }
                    else {
                        BXReadyMenu.closeMenu();
                        $(this).data("show", "N");
                    }
                    BXReadyMenu.activateButton(this);
                }
                else {

                    if($(this).data("target")=="region"){
                        $('#myModalRegion').modal('toggle');

                        if($('.btn-t').length) {
                            $('.btn-t').trigger('click');
                        }

                        if($('.btn-t .other-selector-js').length) {
                            $('.btn-t .other-selector-js').trigger('click');
                        }

                    }
                    else {
                        id = 'bxr-mobile-'+$(this).data("target");
                        BXReadyMenu.closeSlides(id);
                        $('#'+id).slideToggle(400);

                        BXReadyMenu.activateButton(this);
                    }
                }
            }
        );

        $(document).on(
            'click',
            '.bxr-mobile-push-menu #bxr-multilevel-menu li.parent',
            function(){
                state = $(this).attr('menu-state');
                parentId = $(this).data('parent');
                BXReadyMenu.showChildren(parentId);
            }
        );

        $(document).on(
            'click',
            '.bxr-mobile-push-menu #bxr-multilevel-menu li.child',
            function(){
                state = $(this).attr('menu-state');
                parentId = $(this).data('parent');
                BXReadyMenu.closeChildren(parentId);
            }
        );

        $(window).resize(
            function(){
                if (BXReadyMenu.state == 'open') BXReadyMenu.resize();
            }
        );
    });
})( jQuery );