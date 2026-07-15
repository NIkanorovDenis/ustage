(function() {
    if (!!window.JCTopMenu)
        return;
    
    window.JCTopMenu = function(params) {
        this.params = params;
        this.init();
    };
    
    window.JCTopMenu.prototype = {
        init: function(){
			
			
            var _this = this;
            $('ul.bxr-flex-menu').each(function(){							
				_this.liToEndMenu($(this));				
                _this.resize($(this));
            });

            $(window).resize(function() {
                $('ul.bxr-flex-menu').each(function(){
                    _this.resize($(this));
                });
            });
            
            if($("ul.bxr-flex-menu").hasClass("isModalBackdrop")) {                
                $('ul.bxr-flex-menu').hover(
                    function(){
                        $(".modal-backdrop.in").show();
                    },
                    function(){
                        $(".modal-backdrop.in").hide();
                    }
                );
            }

            if( $("ul.bxr-flex-menu").data("first-catalog") == "Y" )
                _this.leftMenuJoin();

            _this.initTouchEvents();
        },
		
        liToEndMenu: function(oneMenu) { 
			
			var tWidth = window.outerWidth;       
			if (tWidth > 991 && tWidth < 1780) {
				oneMenu.find('>li').last().addClass('bxr-end-element');
				var alllilast = oneMenu.find('>li.bxr-end-element');
				var allli = oneMenu.find('>li');
				allli.each(function(indx, element) {
					if ($(element).data('toend') == 'Y') {
						$(element).insertBefore(alllilast);
					}
				})
			}		

        },		
        
        leftMenuJoin: function() {
            var bxrLeftColumnJs = $(".bxr-left-column-js");
            if(bxrLeftColumnJs.hasClass("isHidden"))
                bxrLeftColumnJs.addClass('bxr-left-column-top-calc');
            else if(!bxrLeftColumnJs.parent().hasClass("bxr-show-left-menu"))
                bxrLeftColumnJs.addClass('bxr-left-column-top');
        },

        showMenu: function(oneMenu) {
            oneMenu.css("visibility", "visible");
            oneMenu.css("overflow", "visible");
            oneMenu.data("visibility", "1");
        },

        resetChanges: function(oneMenu){
            oneMenu.find(">li").each(function(){
                $(this).css('display','block');
                $(this).removeClass("bxr-hover-menu-right");
                $(this).removeClass("bxr-last-element");
                if (!$(this).is('.other') && !$(this).is('.li-visible'))
                    $(this).css('width','auto');
            });

            oneMenu.find('.bxr-flex-menu-other').css('display', 'none');
        },
        
        howManyElementFit: function(oneMenu){
            var _this = this;
            var result = {};
            count = 0;
            sumWidth = 0;
            fullWidth = oneMenu.width();
            remaining = fullWidth;
           
            oneMenu.find('> li').each(function(indx, element){
                if(indx == 0 && oneMenu.data("first-catalog") == "Y")
                     var w = _this.resizeWidthFirst(element);
                else
                     var w = $(this).innerWidth();
                    
                sumWidth += w;

                if (sumWidth<fullWidth) {
                    ++count;
                    remaining -= w;
                }
            });
                        
            result.count = count;
            result.remaining = remaining;
            
            
            return result;
        },
        
        showOther: function(oneMenu){
            oneMenu.find('.bxr-flex-menu-other').css('display', 'block');
            oneMenu.find('.bxr-flex-menu-other').html('');
            
            addHTML = '<a href="#"><span class="fa fa-ellipsis-h"></span></a>';
            strAddUL = '<ul>';
                
            divMenu = "bxr-top-menu-other";
            if(oneMenu.data("style-menu") == "light")
                divMenu += " menu-arrow-top";
                
            liHover = "";
            switch (oneMenu.data("style-menu-hover")) {
                case "color": liHover = "bxr-color-flat bxr-bg-hover-dark-flat"; break;
                case "light": liHover = "bxr-children-color-hover"; break;
                case "dark": liHover = "bxr-dark-flat bxr-bg-hover-flat"; break;
            }
            
            liHoverSecected = "";
            switch (oneMenu.data("style-menu-hover")) {
                case "color": liHoverSecected = "bxr-color-dark-flat"; break;
                case "light": liHoverSecected = "bxr-children-color"; break;
                case "dark": liHoverSecected = "bxr-color-flat"; break;
            }
            
            var otherSelect = false;

            var i = 0;
            oneMenu.find(">li").not('.other').not('.li-visible').each(function(){
                if ($(this).data('visible') == 0) {
                    if($(this).attr("data-selected") == 1) {
                        strAddUL += '<li data-selected="1" class="l-2 ' + liHover + ' ' + liHoverSecected + '">'+$(this).children('a').get(0).outerHTML+'</li>';
                        otherSelect = true;
                    }
                    else
                        strAddUL += '<li class="l-2 ' + liHover + '">'+$(this).children('a').get(0).outerHTML+'</li>';
                    ++i;
                }
            });

            strAddUL += '</ul>';
            strAddUL = "<div class='" + divMenu + "'>"+strAddUL+"</div>";
                
            oneMenu.find('.bxr-flex-menu-other').html(addHTML+strAddUL);
            
            if(otherSelect)
                oneMenu.find('.bxr-flex-menu-other').addClass(liHoverSecected);
            else
                oneMenu.find('.bxr-flex-menu-other').removeClass(liHoverSecected);
                
            if(i == 0)
                oneMenu.find('.bxr-flex-menu-other').css('display', 'none');
        },
        
        hideNotFit: function(oneMenu){
            var _this = this;
            flagFull = false;
            howMany = window.JCTopMenu.prototype.howManyElementFit(oneMenu);
            li = oneMenu.find('>li').not(".other").not(".li-visible");
            liVisible = oneMenu.find('> li.li-visible');

            liVisible.each(function(indx, element){
                if(indx == 0 && oneMenu.data("first-catalog") == "Y")
                     var w = _this.resizeWidthFirst(element);
                else
                     var w = $(this).innerWidth();
                
                if(howMany.remaining > w) {
                    howMany.remaining -= w;
                }
                else {
                    --howMany.count;
                    howMany.remaining += $(li[howMany.count]).innerWidth() - w;
                }
            });
            
            if(li.length>howMany.count && howMany.remaining<oneMenu.find('> li.other').innerWidth())
                --howMany.count;
                        
            
            li.each(function(indx, element){
                if(indx < howMany.count){
                    $(element).data('visible', 1);
                    $(element).find(">a").data('visible', 1);
                }
                else {
                    if(!($(element).hasClass("li-visible"))) {
                        $(element).data('visible', 0);
                        $(element).find(">a").data('visible', 0);
                        $(element).css('display', 'none');
                        flagFull = true;
                    }
                }
            });
            
            li.filter(":visible").last().addClass("bxr-hover-menu-right");
            
            if(flagFull)
                _this.showOther(oneMenu);
            
        },
        
        resizeWidthFirst: function(el) {            
            var w = $(".bxr-show-left-menu-conteiner").width();
            $(el).width(w + "px");
            return w;
        },
        
        resizeWidth: function(oneMenu) {
            var _this = this;
            jsObj = oneMenu.get()[0];
            fullWidth = Math.floor(jsObj.getBoundingClientRect().width);
            li = oneMenu.find("> li:visible").not(".other").not(".li-visible");
            other = oneMenu.find('>li.other:visible, > li.li-visible:visible');
            widthOther = 0;
            widthLi = 0;
                        
            other.each(function(indx, element){
                widthOther += Math.ceil($(element).innerWidth())+1;
            });
            
            li.each(function(indx, element){
                widthLi += Math.ceil($(element).innerWidth())+1;
            });
            
            distributePX = fullWidth-widthLi-widthOther;
            
            if(oneMenu.data("first-catalog") == "Y")
                forWidthElements = Math.floor(distributePX/(li.length-1));
            else
                forWidthElements = Math.floor(distributePX/li.length);
            
            forWidthElement = fullWidth-widthOther;
            
            li.each(function(indx, element){
                if(indx == 0 && oneMenu.data("first-catalog") == "Y" ) {
                    var w = window.JCTopMenu.prototype.resizeWidthFirst(element);
                    forWidthElement -= w;
                }
                else {
                    $(element).width($(element).width() + forWidthElements + "px");
                    forWidthElement -= $(element).innerWidth();
                }
                                
                if((li.length-1)==indx)
                    $(element).width($(element).width() + forWidthElement + "px");
                
            });

            oneMenu.find('>li').filter(":visible").last().addClass("bxr-last-element");
            _this.showMenu(oneMenu);
        },
        
        resize: function(oneMenu){
            var _this = this;
            oneMenu.css('width', '100%');
            
            var tWidth = window.outerWidth;            
            if(tWidth==0)
                tWidth =screen.width;
            
            if (tWidth <320 && oneMenu.css('display') != 'none') {
                return;
            }
            
            oldResize = oneMenu.data("resizeWidth");
            
            if(oldResize!=undefined && oldResize==oneMenu.width()) {
                return;
            }
        
            oneMenu.data("resizeWidth", oneMenu.width());

            _this.resetChanges(oneMenu);
            _this.hideNotFit(oneMenu);
            
            if(oneMenu.data("stretch") == "Y")
                _this.resizeWidth(oneMenu);
            else {
                if(oneMenu.data("first-catalog") == "Y")
                    _this.resizeWidthFirst(oneMenu.find("> li:visible").not(".other").not(".li-visible").eq(0));

                _this.showMenu(oneMenu);
            }
        },

        initTouchEvents: function() {
            var touchItems = $('nav ul.bxr-flex-menu li.bxr-c-touch > a');
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
                    }
                }
            );
        }
    }

})();