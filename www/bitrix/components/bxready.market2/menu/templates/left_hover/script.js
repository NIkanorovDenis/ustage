(function() {
    if (!!window.JCLeftMenu)
        return;
    
    window.JCLeftMenu = function() {
        this.init();
    };
    
    window.JCLeftMenu.prototype = {
        hLi: 48,
        boolMaxHeight: false,
        init: function() {
            var _this = this;
            if($(".bxr-left-column-js").hasClass("isHidden")) {
                $('.bar-menu-rotate').show();
                $(document).on("mouseenter", '.bxr-show-left-menu, .bxr-left-column-js', function(){
                    $(".bxr-left-column-js").show();
                    if(!_this.boolMaxHeight) {
                        _this.hLi = $('.bxr-left-menu-hover li').outerHeight();
                        _this.setLeftMenuMaxH();
                        $(window).resize(function() {
                            _this.setLeftMenuMaxH();
                        });
                        _this.boolMaxHeight = true;
                    }
                    $(".bxr-logo-top-panel .bar-menu-rotate .fa").addClass("rotate180");
                });
                $(document).on("mouseleave", '.bxr-show-left-menu, .bxr-left-column-js', function(){
                    $(".bxr-left-column-js").hide();
                    $(".bxr-logo-top-panel .bar-menu-rotate .fa").removeClass("rotate180");
                });
            }
            else {
                this.hLi = $('.bxr-left-menu-hover li').outerHeight();
            }

            if($(".bxr-left-menu-hover").hasClass("isModalBackdrop")) {                
                $('.bxr-left-menu-hover').hover(
                    function(){
                        $(".modal-backdrop.in").show();
                    },
                    function(){
                        $(".modal-backdrop.in").hide();
                    }
                );
            }
    
            this.initScroll();
            
            $('ul.bxr-left-menu-hover > li.top-element-js li').on('mouseenter', function() {
                _this.autoPosition($(this), $('> ul', $(this)));
            });
            
            $('.bxr-left-menu-hover > li.top-element-js').on('mouseenter', function() {
                _this.autoPosition($(this), $('> div', $(this)));
            });

            this.initTouchEvents();
            
        },
        
        autoPosition: function($menuItem, $submenuWrapper) {
            if(!$submenuWrapper.length>0)
                    return false;

            $menuItem.attr('style', '');
            $submenuWrapper.attr('style', '');

            var menuItemPos = $menuItem.position();
            var eTop = menuItemPos.top;
            var inaccuracy = 10;

            var wHeight = $(window).height();

            var ofsetTop = $submenuWrapper.offset().top-$(window).scrollTop();
            /*if(ofsetTop < 0)
                ofsetTop = 0;*/

            var availableHeight = wHeight-ofsetTop-eTop+inaccuracy;            
            var eHeight = $submenuWrapper.height();

            while(eHeight>availableHeight) {
                eTop = eTop - this.hLi;                
                availableHeight = wHeight-ofsetTop-eTop+inaccuracy;
            }        
            if(eTop<0)
                eTop = 0;
            
            $submenuWrapper.css({top: eTop});
        },
        
        initScroll: function() {
            $('.bxr-left-column-js nav > ul').scrollbar();
            $('.scroll-bar').addClass('bxr-color');
        },
        
        setLeftMenuMaxH: function() {
			var menuContaine = $("#button_menu_container");

			if($(window).width()<975 && menuContaine.data("resizeHeight")!=undefined)
			   return true;

			var wHeight = $(window).height();

			if(menuContaine.data("resizeHeight")!=undefined && menuContaine.data("resizeHeight")==wHeight)
			   return true;

			menuContaine.data("resizeHeight", wHeight);  

			var eHeight = menuContaine.parent("div").parent("div").height();
			var tP = menuContaine.parent("div").parent("div").offset()['top'];
			var bbHeight = wHeight - eHeight - tP;

			bbHeight = (~~((bbHeight)/this.hLi))*this.hLi;

			$(".bxr-left-menu-hover").css('max-height', bbHeight+'px');
        },

        initTouchEvents: function() {
            var touchItems = $('nav ul.bxr-left-menu-hover li.bxr-c-touch > a');
            var _this = this;
            touchItems.on(
                'touchend',
                function(e){
                    if ($(this).data('stop-href') == 'stop') {
                        location.href = $(this).data('src');
                    } else {
                        $(this).data('stop-href', 'stop');
                        $(this).data('src', $(this).attr('href'));
                        $(this).attr('href', '#');
                        _this.autoPosition($(this), $('> ul', $(this)));
                        _this.autoPosition($(this), $('> div', $(this)));
                    }
                }
            );
        }
    };
})();