window.dataLayer = window.dataLayer || [];

(function(){
    function setBasketMaxH(bcontainer) {
        
        if(!$(bcontainer).is(":visible"))
            return true;
        
        $(bcontainer+' .bxr-content-scroll').scrollbar();    
        $('.scroll-bar').addClass('bxr-color');
        $(bcontainer+' .scroll-content').closest('.scroll-wrapper').css('max-height', '0px');

        wHeight = $(window).height();
        bHeight = parseInt($(bcontainer).css('height'))

        if(!$(bcontainer).parents("#bxr-basket-row").parent("div").is(".bxr-basket-fixed")) {
            pHeight = parseInt($('.bxr-header-panel').css('height'));
            ePosition = $("header").position().top;
            
            ePosition = ePosition - $(document).scrollTop();
            
            if(ePosition<0)
                ePosition = 0;

            bbHeight = wHeight - pHeight -  bHeight - ePosition;
        }
        else {                
            bbHeight = wHeight - parseInt($("#bxr-basket-row").css("top")) - bHeight;
        }

        $(bcontainer+' .scroll-content').closest('.scroll-wrapper').css('max-height', bbHeight+'px');
    }

    window.BXReady.Market.Basket = {

        objInit: false,
        delayWindow: false,
		precisionFactor: Math.pow(10, 6),
        list: {},

        newQty: function(item, qty) {
            basket = this;

            if (this.params.ajaxUrl.length <= 0) return;
           
            $.ajax({
                url: this.params.ajaxUrl,
                data: {
                    ajaxbuy: 'yes',
                    action: 'newqty',
                    quantity: qty,
                    item: item,
                    rg: Math.random(),
                    siteId: this.params.postData.siteId,
                    template: this.params.postData.template,
                    parameters: this.params.postData.parameters
                },
                type: 'POST',
                success: function(data) {
                    basket.refresh(true, data);
                    BXReady.closeAjaxShadow('bxr-basket-body-shadow');
                }
            });
        },

        changeQtyValue: function(qty, coef, maxQty, type) {
            if(type!=="inc" && type!=="dec" && type!=="arb") return false;
            if(isNaN(coef)) coef = 1;
			coef = Math.round(coef * basket.precisionFactor) / basket.precisionFactor;
            if(isNaN(qty) || qty<0) qty = coef;

            if(type==="inc") {                
                newQty = qty + coef;
                newQty = Math.round(newQty * basket.precisionFactor) / basket.precisionFactor;
            } else if (type==="dec") {
                newQty = qty - coef;
                newQty = Math.round(newQty * basket.precisionFactor) / basket.precisionFactor;           
            } else if (type==="arb") {
				newQty = (Math.ceil(qty/coef)) * coef;
                newQty = Math.round(newQty * basket.precisionFactor) / basket.precisionFactor;
            }
            
            if (maxQty>0 && newQty > maxQty)
                newQty = maxQty;
            if ((newQty < coef && coef<=maxQty) || newQty === 0)
                newQty = coef;
            if (newQty < coef && coef>maxQty)
                newQty = maxQty;
                              
            return newQty;
        },

        addItem: function(form, delay, favor) {
            basket = this;

            if (this.params.ajaxUrl.length <= 0) return;
            

            data = {
                ajaxbuy: 'yes',
                rg: Math.random(),
                siteId: this.params.postData.siteId,
                template: this.params.postData.template,
                parameters: this.params.postData.parameters
            };
            
            $.each(form.serializeArray(), function(i, v) {
                data[v.name] = v.value;
            });

            itemId = form.children('input[name=item]').val();
            if (delay) {
                valueDelay = form.children('input[name=delay]').val();

                if (valueDelay == 'yes') {
                    data.delay = valueDelay;
                    form.children('input[name=delay]').val('no');
                }else{
                    form.children('input[name=delay]').val('yes');
                }
            }

            if (favor) {
                valueFavor = form.children('input[name=favor]').val();

                if (valueFavor == 'yes') {
                    data.favor = valueFavor;
                    form.children('input[name=favor]').val('no');
                } else {
                    form.children('input[name=favor]').val('yes');
                }
            }
            
            notAllProp  = false;
            bProp = {                
                BASKET_PROPS: {}
            };
            if (!delay && !favor) {
                if ($('.bxr-bprop-required').length && $('#bxr-bprop-table-'+itemId).length) {
                    $('.bxr-bprop-required').each(function() {                        
                        prop = $(this);
                        container = prop.closest('.bxr-bprop-value');
                        pVal = prop.val();
                        pCode = prop.data("code");
                        pName = prop.data("name");
                        pSort = prop.data("sort");
                        if (pVal == "false") {
                            container.addClass('wrong-bprop');
                            BXReady.closeAjaxShadow('body-shadow');
                            notAllProp = true;
                        };
                        bProp["BASKET_PROPS"][pCode] = {
                            NAME: encodeURIComponent(pName),
                            CODE: pCode,
                            SORT: pSort,
                            VALUE: encodeURIComponent(pVal),
                        };
                    })
                };
                
                $('.bxr-bprop-optional').each(function() {                        
                    prop = $(this);
                    pVal = prop.val();
                    pCode = prop.data("code");
                    pName = prop.data("name");
                    pSort = prop.data("sort");
                    bProp["BASKET_PROPS"][pCode] = {
                        NAME: encodeURIComponent(pName),
                        CODE: pCode,
                        SORT: pSort,
                        VALUE: encodeURIComponent(pVal),
                    };
                })
            }
                        
            if(window.bUserProp === undefined) {
                bUserProp = {
                    BASKET_PROPS: {}
                };
            }
            
            var getFolder = this.params.getFolder;

            var showPopup = true;            
            if(this.params.showPopup == "false")
                showPopup = false;
                
            if(!showPopup)
                 BXReady.closeAjaxShadow('body-shadow');
            
            if (!notAllProp) {
                $.ajax({
                    url: this.params.ajaxUrl,
                    data: jQuery.extend(true, {}, data, bProp, bUserProp),
                    type: 'POST',
                    success: function(data) {                        
                        basket.refresh(true, data);

                        if (basket.delayWindow != true && delay || favor){}
                        else {
                            BXReady.closeAjaxShadow('body-shadow');

                            if(showPopup) {
                                BXReady.basketPopup = BX.PopupWindowManager.create("basketPopup", null, {
                                    autoHide: true,
                                    offsetLeft: 0,
                                    offsetTop: 0,
                                    overlay : true,
                                    draggable: {restrict:true},
                                    closeByEsc: true,
                                    closeIcon: { },
                                    titleBar: {content: BX.create("span", {html: "<div class='bxr-color bxr-basket-popup bxr-border-bottom-color'>"+BX.message('setItemAdded2BasketTitle')+"</div>"})},
                                content: '<div style="width:366px;height:400px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="'+getFolder+'/images/wait.gif"/></span></div>',
                                    events: {
                                        onAfterPopupShow: function()
                                        {
                                            this.setContent(BX("bxr-basket-popup"));
                                            $(document).on(
                                                'click',
                                                '#continue-buy',
                                                function(){
                                                    BXReady.basketPopup.close();
                                                }
                                            );
                                        }
                                    }
                                });
                            
                                BXReady.basketPopup.show();
                            
                                $('#basketPopup').css({
                                        'top':Math.abs(((window.innerHeight - $('#basketPopup').outerHeight()) / 2)+ $(window).scrollTop()),
                                        'left':Math.abs(((window.innerWidth - $('#basketPopup').outerWidth()) / 2))
                                });
                                $('#basket-popup-product-image > img ').css({
                                        'width':'auto',
                                        'height':'auto'
                                });
                            }
                        }                    
                    }
                });
            }            
        },

        deleteItem: function(item) {
            basket = this;
            if (this.params.ajaxUrl.length <= 0) return;
            
            $.ajax({
                url: this.params.ajaxUrl,
                data: {
                    ajaxbuy: 'yes',
                    action: 'delete',
                    item: item,
                    rg: Math.random(),
                    siteId: this.params.postData.siteId,
                    template: this.params.postData.template,
                    parameters: this.params.postData.parameters
                },
                type: 'POST',
                success: function() {
                    basket.refresh();
                    BXReady.closeAjaxShadow('bxr-basket-body-shadow');
                }
            });
        },
        
        deleteAll: function() {
            basket = this;
            if (this.params.ajaxUrl.length <= 0) return;
            
            $.ajax({
                url: this.params.ajaxUrl,
                data: {
                    ajaxbuy: 'yes',
                    action: 'deleteAll',
                    rg: Math.random(),
                    siteId: this.params.postData.siteId,
                    template: this.params.postData.template,
                    parameters: this.params.postData.parameters
                },
                type: 'POST',
                success: function() {
                    basket.refresh();
                    BXReady.closeAjaxShadow('bxr-basket-body-shadow');
                }
            });
        },

        delayItem: function(item) {
            basket = this;
            if (this.params.ajaxUrl.length <= 0) return;
            
            $.ajax({
                url: this.params.ajaxUrl,
                data: {
                    ajaxbuy: 'yes',
                    action: 'delay',
                    item: item,
                    rg: Math.random(),
                    siteId: this.params.postData.siteId,
                    template: this.params.postData.template,
                    parameters: this.params.postData.parameters
                },
                type: 'POST',
                success: function() {
                    BXReady.closeAjaxShadow('bxr-basket-body-shadow');
                    basket.refresh();
                }
            });
        },

        delayToCart: function(item) {
            basket = this;
            if (this.params.ajaxUrl.length <= 0) return;
            
            $.ajax({
                url: this.params.ajaxUrl,
                data: {
                    ajaxbuy: 'yes',
                    action: 'back',
                    item: item,
                    rg: Math.random(),
                    siteId: this.params.postData.siteId,
                    template: this.params.postData.template,
                    parameters: this.params.postData.parameters
                },
                type: 'POST',
                success: function() {
                    basket.refresh();
                    BXReady.closeAjaxShadow('bxr-basket-body-shadow');
                }
            });
        },

        animateShowIndicator: function(element,sClass) {
            element.css('opacity', '0').addClass(sClass+'-active').animate({'opacity': '1'}, 1000, "easeOutExpo");
        },

        animateHideIndicator: function(sClass) {
            this.css('opacity', '0');
            this.addClass('sClass');
        },

        refreshData: function() {
            if (delayClick)
                $('.tab-delay').click();
            else 
                $('.tab-basket').click();

            basket = this;

            $('#bxr-basket-body').html($('#basket-body-content').html());
            $('#bxr-delay-body').html($('#delay-body-content').html());
            $('#bxr-favor-body').html($('#favor-body-content').html());

            basket.redraw(JSON.parse($('#bxr-basket-data').html()))

            var panels = ['basket', 'delay', 'favor'];

            for (i=0; i<panels.length; i++) {
                $('#bxr-basket-row .bxr-indicator-'+panels[i] + ", #bxr-basket-small-row .bxr-indicator-" + panels[i]).html($('#bxr-basket-content #bxr-indicator-'+panels[i]+'-new').html());
            }
        },

        refresh: function(notRequest, dataRefresh) {
            basket = this;
            
            if (notRequest === true){
                if (dataRefresh !== undefined) {
                    $('#bxr-basket-content').html(dataRefresh);
                    basket.refreshData();
                } else {
                    if (basket.params.startBasketData !== undefined) {
                        basket.redraw();
                    }
                }
            }else{
                if (this.params.ajaxUrl.length <= 0) return;
                
                $.ajax({
                    url: this.params.ajaxUrl,
                    data: {
                        ajaxbuy: 'yes',
                        rg: Math.random(),
                        siteId: this.params.postData.siteId,
                        template: this.params.postData.template,
                        parameters: this.params.postData.parameters
                    },
                    type: 'POST',
                    success: function(data) {
                        $('#bxr-basket-content').html(data);
                        basket.refreshData();
                    }
                });
            }

        },

        basketButtonsInit: function() {
            basket = this;
            $('form.bxr-basket-action').submit(function() {
                window.BXReady.showAjaxShadow('body','body-shadow');
                basket.addItem($(this));
                return false;
            });

            $(document).on(
                'click',
                'form.bxr-basket-action .bxr-basket-add',
                function() {
                    window.BXReady.showAjaxShadow('body','body-shadow');
                    basket.addItem($(this).parent('form'));
                    
                    //https://yandex.ru/support/metrica/ecommerce/data.html#data 

                    var category = '';
                    var category_arr = [];
                    $('.bxr-breadcrumb a [itemprop=name]').each(function(){
                        var cat = $(this).html().trim();
                        if (cat != 'Главная' && cat != 'Каталог') {
                            category_arr.push(cat);
                        }
                    });
                    category = category_arr.join('/');

                    var brand = '';

                    if ($('.tovar-id').length > 0) {
                        var id = $('.tovar-id').val() || 0;
                        var name = $('.tovar-name').val() || 0;
                        var price = $('meta[itemprop=price]').attr('content') || '';
                        var brand = $('meta[itemprop=brand]').attr('content') || 'Ustage Group';
                        var quantity = $('.bxr-basket-action input[name=quantity]').val();
                    }
                    else {
                        var form = $(this).parent('form');
                        var container = $(this).closest('.bxr-element-container');
                        var id = $('.bxr-quantity-text', form).attr('data-item') || 0;
                        var name = $('.bxr-element-name>a', container).html().trim() || '';
                        var price = $('.bxr-market-format-price').html(); 
                        arr = price.split('<'); 
                        price = arr[0]; 
                        price = price.replace(/\s+/g, '');
                        var quantity = $('.bxr-quantity-text', form).val() || 1;
                    }

                    window.dataLayer.push({
                        "ecommerce": {
                            "currencyCode": "RUB",    
                            "add": {
                                "products": [
                                    {
                                        "id": id,
                                        "name": name,
                                        "price": price,
                                        "brand": brand,
                                        "category": category,
                                        "quantity": quantity
                                    }
                                ]
                            }
                        }
                    });

                    return false;
                }
            );

            $(document).on(
                'click',
                'form.bxr-basket-action .bxr-basket-delay',
                function() {
                    basket.addItem($(this).parent('form'), true);
                    return false;
                }
            );

            $(document).on(
                'click',
                'form.bxr-basket-action .bxr-basket-favor',
                function() {
                    $(this).addClass('spinner-wrap');
                    $(this).find(".fa").attr('class', 'fa spinner wheel');
                    if (!$(this).hasClass('bxr-indicator-item-active'))
                        $(this).addClass('bxr-indicator-item-active');
                    basket.addItem($(this).parent('form'), false, true);
                    return false;
                }
            );
    
            $(document).on(
                'click',
                'form.bxr-basket-action .bxr-basket-favor-delete',
                function() {
                    basket.addItem($(this).parent('form'), false, true);
                    return false;
                }
            );

            $(document).on(
                'click',
                '#bxr-basket-body .icon-button-delete',
                function() {
                    itemID = $(this).data('item');
                    BXReady.showAjaxShadow('#bxr-basket-body','bxr-basket-body-shadow');
                    basket.deleteItem(itemID);
                }
            );

            /*$(document).on(
                'click',
                '#bxr-basket-body .icon-button-delete',
                function() {
                    itemID = $(this).data('item');
                    BXReady.showAjaxShadow('#bxr-delay-body','bxr-basket-body-shadow');
                    basket.deleteItem(itemID);
                }
            );*/

            $(document).on(
                'click',
                '#bxr-basket-body .icon-button-delay',
                function() {
                    itemID = $(this).data('item');
                    BXReady.showAjaxShadow('#bxr-basket-body','bxr-basket-body-shadow');
                    basket.delayItem(itemID);
                }
            );

            $(document).on(
                'click',
                '#bxr-basket-body .icon-button-cart',
                function() {
                    itemID = $(this).data('item');
                    BXReady.showAjaxShadow('#bxr-basket-body','bxr-basket-body-shadow');
                    basket.delayToCart(itemID);
                }
            );

            $(document).on(
                'click',
                '.bxr-basket-indicator',
                function() {
                    var panels = ['bxr-basket-body', 'bxr-delay-body', 'bxr-compare-body', 'bxr-favor-body'];
                    itemID = $(this).data('child');
                    
                    if($("div").is(".bxr-basket-fixed")) {
                        $("#bxr-basket-row div").removeClass("bxr-color-flat");
                    }

                    for (i=0; i<panels.length; i++) {
                        if (panels[i] != itemID)
                            $('#'+panels[i]).hide();
                    }

                    if($("div").is(".bxr-basket-dinamic")) {                    
                        if($('#'+itemID).is(":visible")) {
                            $('#bxr-basket-row').animate({'right': '0px'}, 300, '', function(){
                                setBasketMaxH('#'+itemID);
                                $('#'+itemID).hide();
                            });
                        }
                        else {
                            $('#'+itemID).show();
                            $(this).parent("div").addClass("bxr-color-flat");
                            $('#bxr-basket-row').animate({'right': '810px'}, 300, '', function(){
                                setBasketMaxH('#'+itemID);
                            });
                        }
                    }
                    else {
                        if($("div").is(".bxr-basket-fixed")) {
                            if(!$('#'+itemID).is(":visible"))
                                $(this).parent("div").addClass("bxr-color-flat");
                        }
                            
                        $('#'+itemID).fadeToggle(200, function() {
                            setBasketMaxH('#'+itemID);
                        });
                    }
                }
            );

            $(document).on(
                'click',
                '.bxr-basket-tab',
                function() {
                    var tabCode = $(this).data('tab');
                    delayClick = (tabCode == 'delay') ? true : false;
                    
                    $('.bxr-basket-tab').removeClass('active bxr-font-color');
                    $('.bxr-basket-tab[data-tab='+tabCode+']').addClass('active bxr-font-color');
                    $('.bxr-basket-tab-content').removeClass('active');
                    $('.bxr-basket-tab-content[data-tab="'+tabCode+'"]').addClass('active');
                }
            );
    
            $(document).on(
                'click',
                '.tab-basket-clear',
                function() {
                    BXReady.showAjaxShadow('#bxr-basket-body','bxr-basket-body-shadow');
                    basket.deleteAll();
                }
            );

            $(document).on(
                'click',
                '.bxr-quantity-button-minus',
                function() {
                    itemID = parseInt($(this).data('item'));
                    operation = $(this).data('operation');
                    coef = parseFloat($(this).data('ratio'));

                    if (isNaN(coef)) coef = 1;
                    maxQty = coef;

                    startQtyValue = parseFloat($(this).closest('.bxr-basket-group').find('.bxr-quantity-text[data-item='+itemID+']').val());
                    newQty = basket.changeQtyValue(startQtyValue, coef, 0, "dec");
                    
                    if (operation === 'auto_save') {
                        BXReady.showAjaxShadow('#bxr-basket-body','bxr-basket-body-shadow');
                        basket.newQty(itemID, newQty)
                    }

                    $('.bxr-quantity-text[data-item='+itemID+']').val(newQty);
                }
            );

            $(document).on(
                'click',
                '.bxr-quantity-button-plus',
                function() {
                    itemID = parseInt($(this).data('item'));
                    operation= $(this).data('operation');
                    coef = parseFloat($(this).data('ratio'));
                    if (isNaN(coef)) coef = 1;

                    maxQty = parseInt($(this).data('max'));
                    if (isNaN(maxQty)) maxQty = 0;

                    startQtyValue = parseFloat($(this).closest('.bxr-basket-group').find('.bxr-quantity-text[data-item='+itemID+']').val());
                    newQty = basket.changeQtyValue(startQtyValue, coef, maxQty, "inc");

                    if (operation === 'auto_save') {
                        BXReady.showAjaxShadow('#bxr-basket-body','bxr-basket-body-shadow');
                        basket.newQty(itemID, newQty);
                    }
                    
                    $('.bxr-quantity-text[data-item='+itemID+']').val(newQty);
                }
            );

            $(document).on(
                'focusout',
                '.bxr-quantity-text',
                function() {
                    itemID = parseInt($(this).data('item'));
                    operation= $(this).closest('.bxr-basket-group').find('.bxr-quantity-button-plus[data-item='+itemID+']').data('operation');
                    coef = parseFloat($(this).closest('.bxr-basket-group').find('.bxr-quantity-button-plus[data-item='+itemID+']').data('ratio'));
                    maxQty = parseInt($(this).closest('.bxr-basket-group').find('.bxr-quantity-button-plus[data-item='+itemID+']').data('max'));
                    
                    if (isNaN(coef)) coef = 1;
                    if (isNaN(maxQty)) maxQty = 0;

                    startQtyValue = parseFloat($(this).val());
                    newQty = basket.changeQtyValue(startQtyValue, coef, maxQty, "arb");

                    if (operation === 'auto_save') 
                        basket.newQty(itemID, newQty);

                    $('.bxr-quantity-text[data-item='+itemID+']').val(newQty);
                }
            );

            $(document).mouseup(function(e) {
                var container = 'div.bxr-header-panel #basket_container';
                var container2 = 'div.top_fixed_panel #fixed_basket';
                var other = '#bxr-basket-body-shadow';
                var hideContainer = $('div[data-group=basket-group]');
                
                if ($(e.target).parents(container).length === 0 && $(e.target).parents(container2).length === 0 && $(other).has(e.target).length === 0) {
                    $("#bxr-basket-row div").removeClass("bxr-color-flat");
                    
                    if($("div").is(".bxr-basket-dinamic")) {
                        $('#bxr-basket-row').animate({'right': '0px'}, 300, '', function(){
                            var panels = ['bxr-basket-body', 'bxr-delay-body', 'bxr-compare-body', 'bxr-favor-body'];                   
                            for (i=0; i<panels.length; i++) {
                                    $('#'+panels[i]).hide();
                            }
                        });
                    }
                    else {
                        hideContainer.hide();
                    }
                    
                }
            });

        },
        
        autoSetVertical: function(){
        },

        redraw: function(data) {
            basket = this;

            if (data !== undefined) {

                basket.list = data;
                basket.params.startBasketData = data;

            } else {
                basket.list = basket.params.startBasketData;
            }

            $('.bxr-indicator-item-favor').data("favor", 0);

            if (basket.list.FAVOR.length > 0) {
                a = basket.list.FAVOR;

                $('.bxr-counter-favor').html(basket.list.FAVOR.length);
                basket.animateShowIndicator($('.bxr-counter-favor'),'bxr-counter');

                for (var i = 0; i < a.length; i++) {
                    value = basket.list.FAVOR[a[i]];
                    $('.bxr-indicator-item-favor[data-item='+a[i]+']').each(function() {
                        if (!$(this).hasClass('bxr-indicator-item-active'))
                            basket.animateShowIndicator($(this),'bxr-indicator-item');
                        $(this).find(".spinner").attr('class', 'fa fa-heart-o');
                        $(this).removeClass('spinner-wrap');
                    });
                    $('.bxr-indicator-item-favor[data-item='+a[i]+']').data("favor", 1);
                }
            } else {
                $('.bxr-counter-favor').removeClass('bxr-counter-active');
                $('.bxr-indicator-item-favor').removeClass('bxr-indicator-item-active');
            }

            $('.bxr-indicator-item-favor').each(function() {
                if ($(this).data('favor') == 0) {
                    $(this).removeClass('bxr-indicator-item-active');
                    $(this).find(".spinner").attr('class', 'fa fa-heart-o');
                    $(this).removeClass('spinner-wrap');
                }
            });

            $('.bxr-indicator-item').data("basket", 0);

            if (basket.list.ITEMS.length > 0) {
                a = basket.list.ITEMS;

                for (var i = 0; i < a.length; i++) {
                    value = basket.list.ALL[a[i]];

                    $('.bxr-indicator-item-basket[data-item='+a[i]+']').each(function() {
                        if (!$(this).hasClass('bxr-indicator-item-active'))
                            basket.animateShowIndicator($(this),'bxr-indicator-item');
                    });
                    $('.bxr-counter-item-basket[data-item='+a[i]+']').html(value);
                    $('.bxr-indicator-item-basket[data-item='+a[i]+']').data("basket", 1);
                }
            } else
                $('.bxr-counter-item-basket').removeClass('bxr-indicator-item-active');

            $('.bxr-indicator-item-basket').each(function() {
                if ($(this).data('basket') == 0)
                    $(this).removeClass('bxr-indicator-item-active');
            });

            if (Object.keys(basket.list.ALL).length > 0) {
                $('.bxr-counter-basket').html(Object.keys(basket.list.ALL).length);
                basket.animateShowIndicator($('.bxr-counter-basket'),'bxr-counter');
            } else {
                $('.bxr-counter-basket').html(0);
                $('.bxr-counter-basket').removeClass('bxr-counter-active');
            }

            this.startEvents();

        },

        startEvents: function() {
            basket = this;

            $(document).trigger('refreshBasket', {
                'basket': basket.params.startBasketData.ITEMS.length + basket.params.startBasketData.DELAY.length,
                'delay': basket.params.startBasketData.DELAY.length,
                'favor': basket.params.startBasketData.FAVOR.length
            });
        },

        init: function(params){

            basket = this;
            basket.params = params;
            
            if(window.BXReady.Market.Basket.objInit) {
                return true;
            }
            
            window.BXReady.Market.Basket.objInit = true;

            this.params = params;
            this.basketButtonsInit();
            this.refresh(true);
            $(document).ready(function(){
                basket.startEvents();
            });
        }
    };

})(jQuery);