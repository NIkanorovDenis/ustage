(function (window) {	

    jQuery.easing['jswing'] = jQuery.easing['swing'];

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


    window.BXReady = {
        coreData: {},
        rScroll: {
            b: null,
            k: null,
            z: 0,
            p: 20,
            n: 0,
            n2: 20,
            n3: 30,
        },
        lScroll: {
            b: null,
            k: null,
            z: 0,
            p: 20,
            n: 20,
            n2: 0,
            n3: 0,
        },
        dScroll: {
            b: null, //styled div
            k: null, //scroll to bottom
            z: 0, //stop top position
            p: 20, //top stop edge
            n: 20, //bottom stop edge
            n2: 0,
            n3: 0,
        },

        showAjaxShadow: function(element, idArea, localeShadow){

            if (localeShadow == true){
                $(element).addClass('ajax-shadow');
                $(element).addClass('ajax-shadow-r');
            }
            else{
                if ($('div').is('#'+idArea)){

                }
                else
                {
                    $('<div id="'+idArea+'" class="ajax-shadow"><div class=" fa-ajax-shadow"></div></div>').appendTo('body');
                }

                $('#'+idArea).show();
                $('#'+idArea).width($(element).width());
                $('#'+idArea).height($(element).outerHeight());
                $('#'+idArea).css('top', $(element).offset().top+'px');
                $('#'+idArea).css('left', $(element).offset().left+'px');
            }

        },

        closeAjaxShadow: function(idArea, localShadow){
            if (localShadow == true){
                $(idArea).removeClass('ajax-shadow-r');
                $(idArea).removeClass('ajax-shadow');
            }
            else{
                $('#'+idArea).hide();
            }
        },

        scrollTo: function(targetElement){

            $("html, body").animate({
                scrollTop: $(targetElement).offset().top-20 + "px"
            }, {
                duration: 500
            });
        },

        autosizeVertical: function(){
            maxHeight = 0;
            $('div.bxr-v-autosize').each(function(){
                if ($(this).height()> maxHeight){
                    maxHeight = $(this).height();
                };
            });
            $('div.bxr-v-autosize').each(function(){

                    delta = Math.round((maxHeight - $(this).height())/2);
                    $(this).css({'padding-top': delta+'px', 'padding-bottom': delta+'px'});
            });
        },

        setMinPageHeight: function () {
            minHeight = $(window).height() - $('#panel').height() - $('header').height() - $('footer').height();
            $('.bxr-page-content').css('min-height', minHeight+'px');
        },
        /*
         * params:
         * el - object to fix on scroll, e.g. $('#col')
         * bottomLine - block is bottom line, e.g. '#bottom'
         * symbol - key of BXReady array with scroll params
         * clearStyles - if you don't need to fix col on screen width less than 1200
         * setLeftMargin - set left margin on screen width more than 1239
         * */
        fixColScroll: function (element, bottomLine, symbol, clearStyles, setLeftMargin) {
            if (element == null || element == 'undefined') return;
            var a = (typeof(element) == 'string') ? document.querySelector(element) : element;
            if (a == null || a == 'undefined') return;
            if ( ((document.body.clientWidth < 1200 && element != '#bxr-left-col')
                || (document.body.clientWidth < 768 && element == '#bxr-left-col'))
                && clearStyles) {
                $(".bxr-sticky-col").removeAttr("style");
                $(".bxr-stop-col").removeAttr("style");
                $(element).removeAttr("style");
                return;
            }

            var Ra = a.getBoundingClientRect(),
              R1bottom = document.querySelector(bottomLine).getBoundingClientRect().bottom;

            if (Ra.bottom < R1bottom) {
                if (BXReady[symbol]['b'] == null) {
                    var Sa = getComputedStyle(a, ''), s = '';
                    for (var i = 0; i < Sa.length; i++) {
                        if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
                            s += Sa[i] + ': ' +Sa.getPropertyValue(Sa[i]) + '; '
                        }
                    }
                    BXReady[symbol]['b'] = document.createElement('div');
                    BXReady[symbol]['b'].className = "bxr-stop-col";
                    BXReady[symbol]['b'].style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
                    if (document.body.clientWidth > 1239 && setLeftMargin)
                        BXReady[symbol]['b'].style.cssText += 'margin-left: -10px';
                    a.insertBefore(BXReady[symbol]['b'], a.firstChild);
                    var l = a.childNodes.length;
                    for (var i = 1; i < l; i++) {
                        BXReady[symbol]['b'].appendChild(a.childNodes[1]);
                    }
                    a.style.height = BXReady[symbol]['b'].getBoundingClientRect().height + 'px';
                    a.style.padding = '0';
                    a.style.border = '0';
                }
                var Rb = BXReady[symbol]['b'].getBoundingClientRect(),
                    Rh = Ra.top + Rb.height,
                    W = document.documentElement.clientHeight,
                    R1 = Math.round(Rh - R1bottom),
                    R2 = Math.round(Rh - W);
                Rb.height = Rb.height + 200; /**/ 
                const header = document.querySelector('.header');
                let offsetTopHeader = 0;
                if (header) {
                    offsetTopHeader = header.clientHeight - 80;
                }

                if (Rb.height > W) {

                    if (Ra.top < BXReady[symbol]['k']) {  /* scroll down */
                        if (R2 + BXReady[symbol]['n'] > R1) {  /* don't go to the bottom */
                            if (Rb.bottom - W + BXReady[symbol]['n']-BXReady[symbol]['n2'] - 200 <= 0) {  // catch /**/
                                BXReady[symbol]['b'].className = 'bxr-sticky-col';
                                BXReady[symbol]['b'].style.top = W - Rb.height + offsetTopHeader - BXReady[symbol]['n'] + 'px';
                                BXReady[symbol]['z'] = BXReady[symbol]['n'] + Ra.top + Rb.height - W;
                            } else {
                                BXReady[symbol]['b'].className = 'bxr-stop-col';
                                BXReady[symbol]['b'].style.top = - BXReady[symbol]['z'] + 'px';
                            }
                        } else {
                            BXReady[symbol]['b'].className = 'bxr-stop-col';
                            BXReady[symbol]['b'].style.top = (- R1-BXReady[symbol]['n3']-180) +'px';
                            BXReady[symbol]['z'] = R1;
                        }
                    } else {  /* scroll up */
                        if (Ra.top - BXReady[symbol]['p'] < 0) {  /* don't go to the top */
                            if (Rb.top - BXReady[symbol]['p'] >= 0) {  /* catch */
                                BXReady[symbol]['b'].className = 'bxr-sticky-col';
                                BXReady[symbol]['b'].style.top = BXReady[symbol]['p'] + offsetTopHeader + 'px';
                                BXReady[symbol]['z'] = Ra.top - BXReady[symbol]['p'];
                            } else {
                                BXReady[symbol]['b'].className = 'bxr-stop-col';
                                BXReady[symbol]['b'].style.top = - BXReady[symbol]['z'] - 20 + 'px';
                            }
                        } else {
                            BXReady[symbol]['b'].className = '';
                            BXReady[symbol]['b'].style.top = '';
                            BXReady[symbol]['z'] = 0;
                        }
                    }
                    BXReady[symbol]['k'] = Ra.top;
                } else {
                    if ((Ra.top - BXReady[symbol]['p']) <= offsetTopHeader) {
                        if ((Ra.top - BXReady[symbol]['p'] - 200) <= R1) { /**/
                            BXReady[symbol]['b'].className = 'bxr-stop-col';
                            BXReady[symbol]['b'].style.top = - R1 - 50 - BXReady[symbol]['p'] +'px';/**/
                        } else {
                            BXReady[symbol]['b'].className = 'bxr-sticky-col';
                            BXReady[symbol]['b'].style.top = BXReady[symbol]['p'] + offsetTopHeader  + 'px';
                        }
                    } else {
                        BXReady[symbol]['b'].className = '';
                        BXReady[symbol]['b'].style.top = '';
                    }
                }
                window.addEventListener('resize', function() {
                    a.children[0].style.width = getComputedStyle(a, '').width
                }, false);
            }
        }
    };

    window.BXReady.Market = {
        loader: [],
        bestsellersAjaxUrl: '/ajax/bestsellers.php',
        markersAjaxUrl: '/ajax/markers.php',
        basketValues: {},
        setBasketIds: function(id, addMess, mainWrap) {
			
            id = parseInt(id);

            btnWrap = $(mainWrap);
            bxSubscribe = btnWrap.find('.bxr-subscribe-wrap');
            bxrSubscribe = btnWrap.find('.bxr-detail-product-request');
            bxrBasket = btnWrap.find('.bxr-currnet-torg');
            bxrOneClickBuy = btnWrap.find('.bxr-one-click-buy');

            arElement = BXReady.Market.basketValues[id];
			if (arElement) {
				
				msg = arElement["MSG"] + addMess;		

				if (arElement["CATALOG_QUANTITY"] <= 0 && arElement["CATALOG_CAN_BUY_ZERO"] == "N" || arElement["HAS_PRICE"] == "N") {
					
					if (arElement["CATALOG_SUBSCRIBE"] == "Y") {

						bxSubscribe.find(".bxr-detail-subscribe").attr("data-item", arElement["OFFER_ID"]);
						bxSubscribe.find(".bxr-detail-subscribe").data("item", arElement["OFFER_ID"]);
						bxSubscribe.find(".already-subsc").attr("data-item", arElement["OFFER_ID"]);
						bxSubscribe.find(".already-subsc").data("item", arElement["OFFER_ID"]);
						jsOb = bxSubscribe.find(".bxr-detail-subscribe").data("js");
						jsObA = bxSubscribe.find(".already-subsc").data("js");
						if (jsOb != undefined && window[jsOb] != undefined)
							window[jsOb].checkSubscribe();
						if (jsObA != undefined && window[jsOb] != undefined)
							window[jsObA].checkSubscribe();
						
					} else {

						bxrSubscribe.attr("data-oid", arElement["OFFER_ID"]);
						bxrSubscribe.data("oid", arElement["OFFER_ID"]);
						
					}
					
				} else {

					bxrBasket.find(".bxr-quantity-button-minus").attr("data-item", arElement["OFFER_ID"]);
					bxrBasket.find(".bxr-quantity-text").attr("data-item", arElement["OFFER_ID"]);
					bxrBasket.find(".bxr-quantity-button-plus").attr("data-item", arElement["OFFER_ID"]);
					bxrBasket.find(".bxr-basket-item-id").attr("data-item", arElement["OFFER_ID"]);

					bxrBasket.find(".bxr-quantity-button-minus").data("item", arElement["OFFER_ID"]);
					bxrBasket.find(".bxr-quantity-text").data("item", arElement["OFFER_ID"]);
					bxrBasket.find(".bxr-quantity-button-plus").data("item", arElement["OFFER_ID"]);
					bxrBasket.find(".bxr-basket-item-id").data("item", arElement["OFFER_ID"]);

					bxrBasket.find(".bxr-quantity-button-minus").attr("data-ratio", arElement["RATIO"]);
					bxrBasket.find(".bxr-quantity-button-plus").attr("data-ratio", arElement["RATIO"]);

					bxrBasket.find(".bxr-quantity-button-minus").data("ratio", arElement["RATIO"]);
					bxrBasket.find(".bxr-quantity-button-plus").data("ratio", arElement["RATIO"]);

					bxrBasket.find(".bxr-quantity-button-plus").attr("data-max", arElement["QTY_MAX"]);
					bxrBasket.find(".bxr-quantity-button-plus").data("max", arElement["QTY_MAX"]);

					bxrBasket.find(".bxr-quantity-text").val(arElement["START_QTY"]);
					bxrBasket.find(".bxr-basket-item-id").val(arElement["OFFER_ID"]);

					bxrOneClickBuy.attr("data-oid", arElement["OFFER_ID"]);
					bxrOneClickBuy.data("oid", arElement["OFFER_ID"]);
					
				}
			}
			
        },

        setPriceIds: function(id, show, mainWrap) {
            wrap = $(mainWrap);
            wrap.find('.bxr-detail-offers-price-wrap').hide();
            if (show) {
                wrap.find('.bxr-detail-price-wrap').hide();
                wrap.find(mainWrap+'_offer_'+id).show();
            } else
                wrap.find('.bxr-detail-price-wrap').show();
        },

        setAvailBlock: function(id, mainWrap) {
            wrap = $(mainWrap);
            wrap.find('.bxr-detail-avail-wrap').hide();
            wrap.find('.bxr-detail-offer-avail-wrap').hide();
            if (id > 0)
                $(mainWrap+'-'+id).show();
            else
                wrap.find('.bxr-detail-avail-wrap').show();
        }
    };

    $(document).on('click', '.search-btn', function() {
        var search = $('#searchline');
        if(search.is(":visible"))
            search.fadeOut();
        else
            search.fadeIn();
    });

    $(document).on('click', '.delivery-item-more', function() {
        if ($(this).prev('.delivery-item-text').css('display') == 'none'){
            $(this).prev('.delivery-item-text').slideDown();
            $(this).find('.fa-angle-down-js').hide();
            $(this).find('.fa-angle-up-js').show();
        } else {
            $(this).prev('.delivery-item-text').slideUp();
            $(this).find('.fa-angle-down-js').show();
            $(this).find('.fa-angle-up-js').hide();
        }
        return false;
    });

    window.onload = function()
    {
        if (typeof window.BXReady.Market.loader != 'object')
            window.BXReady.Market.loader = [];
        for ( var i in window.BXReady.Market.loader )
        {
            if ( typeof( window.BXReady.Market.loader[i] ) == 'function' ) window.BXReady.Market.loader[i]();
        }
    };

    if (typeof window.BXReady.Market.loader != 'object')
            window.BXReady.Market.loader = [];
    window.BXReady.Market.loader.push(BXReady.autosizeVertical);
    window.BXReady.Market.loader.push(BXReady.setMinPageHeight);


    $(window).resize(function() {
        BXReady.autosizeVertical();
        BXReady.setMinPageHeight();
    });

    $(document).ready(function() {
        BXReady.setMinPageHeight();

        window.addEventListener('scroll', function() { BXReady.fixColScroll('#bxr-right-col', '#bxr-page-content', 'rScroll', true, true) }, false);
        document.body.addEventListener('scroll', function() { BXReady.fixColScroll('#bxr-right-col', '#bxr-page-content', 'rScroll', true, true) }, false);

        window.addEventListener('scroll', function() { BXReady.fixColScroll('#bxr-right-col-detail', '#bxr-page-content', 'dScroll', true, true) }, false);
        document.body.addEventListener('scroll', function() { BXReady.fixColScroll('#bxr-right-col-detail', '#bxr-page-content', 'dScroll', true, true) }, false);
        window.addEventListener('scroll', function() { BXReady.fixColScroll('#bxr-left-col', '#bxr-page-content', 'lScroll', true, false) }, false);
        document.body.addEventListener('scroll', function() { BXReady.fixColScroll('#bxr-left-col', '#bxr-page-content', 'lScroll', true, false) }, false);

        if ($('.vt-video-wrap').length > 0) {

            setTimeout(function(){
                $('.vt-video-wrap').each(function(){

                    var video = $(this).attr('data-url');

                    //var video_wrap = $('.vt-video-youtube', this).html().trim();

                    var html = "<iframe type='text/html' width='100%' src='"+video+"' frameborder='0'></iframe>";
                    $('.vt-video-youtube', this).html(html);
                    $('.vt-video-play', this).hide();
                });
            }, 1000);

        }

    });

  function setCookie(name,value,days, hours=null, minutes=null) {
    var expires = "";
    var date = new Date();
    var time = date.getTime();

    if (days) time += days*24*60*60*1000;
    if (hours) time += hours*60*60*1000;
    if (minutes) time += minutes*60*1000;

    date.setTime(time);
    expires = "; expires=" + date.toUTCString();
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
  }

  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');

    for (var i=0;i < ca.length;i++) {
      var c = ca[i];

      while (c.charAt(0) === ' ') {
        c = c.substring(1,c.length);
      }

      if (c.indexOf(nameEQ) === 0) {
        return c.substring(nameEQ.length,c.length);
      }
    }

    return null;
  }

  $(document).ready(function() {
    // См. также footer
    let dateStart = new Date('2026-06-11 00:00:00').getTime();
    let dateEnd = new Date('2026-06-13 00:00:00').getTime();

    let date = new Date().getTime();

    let triggerButton = $('[data-target="#bxr-dayoff-popup"]');

    if (triggerButton.length > 0) {
        let forceOpen = location.hash === '#announcement-demo';

        if ((date >= dateStart && date < dateEnd) || forceOpen) {
          let isAnnouncementClosed = getCookie('is_announcement_closed');

          if (!isAnnouncementClosed) {
            triggerButton.trigger('click');

            if (!forceOpen) {
             setCookie('is_announcement_closed', '1', null , null , 10);
            }
          }
        }
    }

    let dateStart2 = new Date('2026-05-08 00:00:00').getTime();
    let dateEnd2 = new Date('2026-05-12 00:00:00').getTime();    

    let triggerButton2 = $('[data-target="#bxr-dayoff-popup2"]');

    if (triggerButton2.length > 0) {
        let forceOpen = location.hash === '#announcement-demo';

        if ((date >= dateStart2 && date < dateEnd2) || forceOpen) {
          let isAnnouncementClosed = getCookie('is_announcement_closed');

          if (!isAnnouncementClosed) {
            triggerButton2.trigger('click');

            if (!forceOpen) {
             setCookie('is_announcement_closed', '1', null , null , 10);
            }
          }
        }
    }
    
  });

  /*
  $(document).ready(function() {
    var dateStart = new Date('2025-12-29 00:00:00').getTime();
    var dateEnd = new Date('2026-01-11 00:00:00').getTime();

    var date = new Date().getTime();

    var triggerButton = $('[data-target="#bxr-new-year-popup_2"]');

    if (triggerButton.length > 0) {
        var forceOpen = location.hash === '#announcement-demo_2';

        if ((date >= dateStart && date < dateEnd) || forceOpen) {
          var isAnnouncementClosed = getCookie('is_announcement_closed_2');

          if (!isAnnouncementClosed) {
            triggerButton.trigger('click');

            if (!forceOpen) {
             setCookie('is_announcement_closed_2', '1', null , null , 10);
            }
          }
        }
    }
    
  });
  */

  $(document).ready(function() {
    /*
    var dateStart = new Date('2025-12-25 21:30:00').getTime();
    var dateEnd = new Date('2025-12-29 00:00:00').getTime();


    var dateStart2 = new Date(2022, 4, 7, 0, 0, 0, 0).getTime();
    var dateEnd2 = new Date(2022, 4, 9, 23, 59, 59, 0).getTime();

    var date = new Date().getTime();

    var triggerButton = $('[data-target="#bxr-may-popup"]');
    var may_session = triggerButton.attr('data-session');

    var popup_may = 0;
    if (isSessionStorageSupported()) {
        popup_may = window.sessionStorage.getItem("popup_may");
    }

    if (may_session == 1) popup_may = 1;


    if (triggerButton.length > 0) {
        var forceOpen = location.hash === '#announcement-demo-may';
       
        if ((date >= dateStart && date < dateEnd) || (date >= dateStart2 && date < dateEnd2) || forceOpen) {

            if (popup_may != 1 || forceOpen) {
                if (isSessionStorageSupported()) {
                    window.sessionStorage.setItem("popup_may", 1);
                }
                triggerButton.trigger('click');
                $.ajax({
                url: '/ajax/?popup_may=1', 
                    type: 'GET',
                    data: {},
                    success: function(html) {

                    },
                    error: function(html) {}
                });
            }
        }
    }
    */


    /*var triggerButton_n = $('[data-target="#bxr-nov-popup"]');
    var nov_session = triggerButton_n.attr('data-session');

    var popup_nov = 0;
    if (isSessionStorageSupported()) {
        popup_nov = window.sessionStorage.getItem("popup_nov1");
    }

    if (nov_session == 1) popup_nov = 1;

    if (triggerButton_n.length > 0) {       
        
        if (popup_nov != 1) {
            if (isSessionStorageSupported()) {
                window.sessionStorage.setItem("popup_nov1", 1);
            }
            triggerButton_n.trigger('click');         
        }
        
    }*/



    var triggerButton_n = $('[data-target="#bxr-june"]');
    var feb_session = triggerButton_n.attr('data-session');


    var popup_24 = 0;
    if (isSessionStorageSupported()) {
        popup_24 = window.sessionStorage.getItem("popup_24");
    }

    if (feb_session == 1) popup_24 = 1;

    if (triggerButton_n.length > 0) {       
        
        if (popup_24 != 1) {
            if (isSessionStorageSupported()) {
                window.sessionStorage.setItem("popup_24", 1);
            }
            triggerButton_n.trigger('click');         
        }
        
    }



    const widget = $('.tg-widget-wrapper');

    var popup_tg = 0;
    if (isSessionStorageSupported()) {
        popup_tg = window.sessionStorage.getItem("popup_tg");
    }
    if (popup_tg != 1) {
        setTimeout(() => {
            widget.show(700)
            if (isSessionStorageSupported()) {
                window.sessionStorage.setItem("popup_tg", 1);
            }
        }, 2000)
    }

    $(document).on('click', '.tg-widget__close', function(e){
        e.preventDefault();
        widget.hide(500);
    })


  });

})(window);


function isSessionStorageSupported() {
    var storage = window.sessionStorage;
    try {
      storage.setItem('test', 'test');
      storage.removeItem('test');
      return true;
    } catch (e) {
      return false;
    }
}

const setMasks = () => {

    setTimeout(() => {
        if ($('input[autocomplete="tel"]').length) {
            $('input[autocomplete="tel"]').mask("+7(999)999-99-99");
        }	

        if ($('input[data-code*="PHONE"]').length) { 
            $('input[data-code*="PHONE"]').each(function(){
                $(this).mask("+7(999)999-99-99");
            })		
        }
    }, 300);
	
}


$(document).ready(function() {

    $('.modal').on('shown.bs.modal', function (e) {
        setMasks();
    })

    if ($('.detail-images').length > 0) {

        var i = 1;
        $('.detail-images img').each(function(){
            $(this).attr('data-i', i);
            i++;
        });

        var images = $('.detail-images').html();
        $('.detail-images-wrap').append("<div class='detail-images-small'>"+images+"</div>");

        $('.detail-images-small img[data-i=1]').addClass('detail-images-small-active');

        $('body').on('click', '.detail-images .slick-arrow', function() {
            $('.detail-images').slick('slickPause');
        });

        $('.detail-images').slick({
            dots: true,
            draggable: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            infinite: true,
            speed: 450,
            autoplay: false,
            autoplaySpeed: 7000
        });

        $('.detail-images').on('afterChange', function(event, slick, currentSlide, nextSlide){
            var i = Number(currentSlide) + 1;
            $('.detail-images-small img').removeClass('detail-images-small-active');
            $('.detail-images-small img[data-i='+i+']').addClass('detail-images-small-active');
        });

        $(document).on('click', '.detail-images-small img', function() {
            var i = $(this).attr('data-i');
            ii = i - 1;
            $('.detail-images-small img').removeClass('detail-images-small-active');
            $(this).addClass('detail-images-small-active');
            $('.slick-dots #slick-slide1'+ii).click();
        });
    }

    //Partnership form
    if ($('.partnership-form').length > 0 && $('#bxr-partnership-popup').length > 0) {
        var html = $('#bxr-partnership-popup .modal-content').html();
        $('.partnership-form').html(html);
        $('#bxr-partnership-popup .modal-content').html('');
    }

    if ($('.services-form').length > 0 && $('#bxr-services-popup').length > 0) {
        var html = $('#bxr-services-popup .modal-content').html();
        $('.services-form').html(html);
        $('#bxr-services-popup .modal-content').html('');
    }

    if ($('.feedback-form').length > 0 && $('#bxr-services-popup').length > 0) {
        var html = $('#bxr-services-popup .modal-content').html();
        var html_new = html.replace( "Обратная связь", "Остались вопросы?" );
        $('.feedback-form').html(html_new);
        //$('#bxr-feedback-popup .modal-content').html('');
    }

    category_btn();
	
	
	setMasks();
	
});

$(window).on('load', function(){
	$('#bx-soa-paysystem .bx-soa-pp-item-container .bx-soa-pp-company:nth-child(2)').find('.bx-soa-pp-company-graf-container').remove();
	$('#bx-soa-paysystem .bx-soa-pp-item-container .bx-soa-pp-company:nth-child(2)').find('.bx-soa-pp-company-smalltitle').remove();
	$('#bx-soa-paysystem .bx-soa-pp-item-container .bx-soa-pp-company:nth-child(2)').width(0);
});

function category_btn(){
    if ($('.bxr-hidden-slist-mobile-btn').length) {
        //var path = $('body').attr('data-uri') || '';
        //if (path.indexOf('/filter/') > 0 || $('.bxr-breadcrumb-item').length > 3) {
            $('.bxr-hidden-slist-mobile-btn').addClass('bxr-hidden-slist-mobile-btn-show');
            $('.bxr-section-list-wrap.bx_catalog_tile').hide();
        //}
    }
}

function hideOffers(type, primary, attribute, filter_color){
    $('.bx_'+type+' li',  primary).each(function(){
        var exist = $(this).attr(attribute) || '';
        if (exist == 0) {
            $(this).addClass('bx-exist-hide');
        }
    });
    var find = false;
    var active_exist_hide = $('.bx_'+type+' .bx_active.bx-exist-hide',  primary).length>0 || false;
    if (active_exist_hide) {
        if (filter_color) { 
            var parent = $(primary).closest('.t_1_section');
            parent.hide();
        }
        else { 
            $('.bx_'+type+' li', primary).each(function(){
                if (!find) {
                    if (!$(this).hasClass('bx-exist-hide')) {
                        if (!$(this).hasClass('bx_active')) {
                            $(this).trigger('click');
                        }
                        find = true;
                    }
                }
            });
        }
    }

}

function scu_check(attribute, filter_color){
	
    var checkColor = attribute == 'color' ? true : false;
	
	$('.bxr-element-offers').each(function(){
		
		if (attribute == 'color') { 
			
			$('.bx_scu li', this).each(function(){ 
				filter_color.forEach((value, index) => { 
					if ($(this).attr('title') == value) {
						$(this).trigger('click');
						return false;
					}					
				})
			});

		} else {
			
			hideOffers('scu', this, attribute, filter_color);
			hideOffers('size', this, attribute, false);			
			
		}
		
    });
	
    setTimeout(function(){
        $('.bx_size .bx-exist-hide.bx_active').each(function(){
            if (!checkColor) {
				$(this).parent().find('li:not(.bx-exist-hide)').trigger('click');
			}
        });
    }, 400);
	
}


// function scu_check(attribute , filter_color){
//     $('.bxr-element-offers').each(function(){
//         $('.bx_scu li', this).each(function(){
//             var exist = $(this).attr(attribute) || '';
//             if (exist == 0) {
//                 $(this).addClass('bx-exist-hide');
//             }
//         });
//         var find = false;
//         var active_exist_hide = $('.bx_scu .bx_active', this).hasClass('bx-exist-hide') || false;
//         if (active_exist_hide) {
//             if (filter_color) {
//                 var parent = $(this).closest('.t_1_section');
//                 parent.hide();
//             }
//             else {
//                 $('.bx_scu li', this).each(function(){
//                     if (!find) {
//                         if (!$(this).hasClass('bx-exist-hide')) {
//                             if (!$(this).hasClass('bx_active')) {
//                                 $(this).trigger('click');
//                             }
//                             find = true;
//                         }
//                     }
//                 });
//             }
//         }
//     });
// }

function bxr_element_offers_available(){
	
    if ($('.bxr-element-offers').length == 0) return;
    if ($('#arrFilter_2061_2891637319').length == 0) return;

    //еще проверка цветов
    var filter_color = false;
	var cvetName = [];
    if ($('.bx_filter_parameters_box_title').length > 0) {
        $('.bx_filter_parameters_box_title').each(function(){
            var title = $(this).html().trim();
            if (title == 'Цвет') {
                var parent = $(this).parent();
                if ($('.bx_filter_input_checkbox input:checked', parent).length > 0) { 
                    filter_color = true;					
					
					/*if ($('.bx_filter_input_checkbox input:checked', parent).length == 1) {
						cvetName = $('.bx_filter_input_checkbox input:checked', parent).nextAll('.bx_filter_param_text').text(); 
					}*/
					$('.bx_filter_input_checkbox input:checked').each(function(){
						cvetName.push($(this).nextAll('.bx_filter_param_text').text());
					})					
                }
            }
        });
    }
	
    if ($('#arrFilter_2061_2891637319').prop('checked')) {
        scu_check('data-exist' , filter_color)
    }

    if ($('.bxr-marker-sale').hasClass('active')){
        scu_check('data-sale' , filter_color)
    }	

	if (cvetName) {
		scu_check('color', cvetName);
	}
	
}
$(document).ready(function(){
    bxr_element_offers_available();
});

$(document).ready(function(){
   
    $('.header_phone_line .bxr-bg-hover-light-flat').on('click', function(event){        
        event.preventDefault();
        $('.header_phone_line').toggleClass('open');
    });


    var consentStorageKey = 'ustage_cookie_consent_v1';
    var consentIdStorageKey = 'ustage_cookie_consent_id';

    function getStoredValue(key) {
        try {
            return window.localStorage.getItem(key);
        } catch (error) {
            return null;
        }
    }

    function setStoredValue(key, value) {
        try {
            window.localStorage.setItem(key, value);
        } catch (error) {
            // The server log remains best-effort when browser storage is blocked.
        }
    }

    function getConsentId() {
        var consentId = getStoredValue(consentIdStorageKey);
        if (consentId) {
            return consentId;
        }

        if (window.crypto && typeof window.crypto.randomUUID === 'function') {
            consentId = window.crypto.randomUUID();
        } else {
            consentId = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (character) {
                var random = Math.random() * 16 | 0;
                var value = character === 'x' ? random : (random & 0x3 | 0x8);
                return value.toString(16);
            });
        }

        setStoredValue(consentIdStorageKey, consentId);
        return consentId;
    }

    function logCookieConsent(decision) {
        var payload = new URLSearchParams();
        payload.set('consent_id', getConsentId());
        payload.set('decision', decision);
        payload.set('page', window.location.pathname);

        window.fetch('/local/ajax/cookie-consent.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: payload.toString(),
            keepalive: true
        }).catch(function () {
            // The visitor's local choice still applies if audit logging is unavailable.
        });
    }

    var cookieConsent = getStoredValue(consentStorageKey);
    if (cookieConsent !== 'accepted' && cookieConsent !== 'rejected') {
        $('.info-panel').show();
    } else if (cookieConsent === 'accepted' && typeof window.ustageLoadOptionalCookies === 'function') {
        window.ustageLoadOptionalCookies();
    }

    $('.cookie-consent-button').on('click', function () {
        var decision = $(this).data('cookie-consent');
        if (decision !== 'accepted' && decision !== 'rejected') {
            return;
        }

        setStoredValue(consentStorageKey, decision);
        $('.info-panel').hide();
        logCookieConsent(decision);

        if (decision === 'accepted' && typeof window.ustageLoadOptionalCookies === 'function') {
            window.ustageLoadOptionalCookies();
        }
    });
	
	$('body').on('submit', '.modal .bxr-form-body', function () {
        if (typeof window.ym === 'function') {
            window.ym(80012047, 'reachGoal', 'formy-os');
        }
    });

    /*
    var list = $('.bxr-section-list-wrap.bx_catalog_tile');
    var hash = top.location.hash;
    if (list.length > 0) {

        if (hash != '#test') {

            //$('.bx_filter_container').before(
            //    "<div class='bx_filter_parameters_box bx_filter_parameters_box_departments'>" +
            //        "<div class=\"bx_filter_parameters_box_title  \" data-role=\"prop_angle\" onclick=\"smartFilter.hideFilterProps(this)\"> Список разделов </div>" +
            //        "<div class=\"bx_filter_block\" data-role=\"bx_filter_block\" style=\"\"></div>" +
            //        "<div class=\"filter-separator\"></div>" +
            //    "</div>"
            //);

            $('.bx_filter_container').before(
                "<div class='bx_filter_parameters_box bx_filter_parameters_box_departments'>" +
                    "<div class=\"bx_filter_block\" data-role=\"bx_filter_block\" style=\"display: block;\"></div>" +
                    "<div class=\"filter-separator\"></div>" +
                "</div>"
            );

            var departments =  $('.bx_filter_parameters_box_departments');

            list.find('.bx_catalog_tile_title').each(function(){
              departments.find('.bx_filter_block').append($(this).prop('outerHTML'));
            });

        }
        else {

            $('.bxr-section-list-wrap.bx_catalog_tile').show();

        }
    }
    */
});


function addScriptToHead(src) {
    var script = document.createElement('script');
    script.src = src;
    document.head.appendChild(script);
}


/*$(document).ready(function(){

    var ismaskLoaded = false; 
    function loadmask(callback) {
        if (!ismaskLoaded) {
            ismaskLoaded = true;
            addScriptToHead('/bitrix/templates/market2_v1/js/jquery.maskedinput.js');
        }

        var waitFormask = setInterval(function() {
            if (typeof jQuery.fn.mask !== 'undefined') {
                clearInterval(waitFormask);
                callback();
            }
        }, 500);
    }

    if ($('input[autocomplete="tel"]').length) {
        loadmask(function() {
            jQuery('input[autocomplete="tel"]').mask("+7(999)999-99-99");
        });
    }

});*/


function decodeEntities(encodedString) {
	var textArea = document.createElement('textarea');
	textArea.innerHTML = encodedString;
	return textArea.value;
}
