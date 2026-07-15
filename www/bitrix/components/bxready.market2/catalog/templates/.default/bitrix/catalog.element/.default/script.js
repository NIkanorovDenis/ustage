$(document).on('click', '.bxr-share-group', function() {
    $('.bxr-share-icon-wrap').toggle();
});

$(document).on("change", ".bxr-bprop-required", function() {
    $(this).closest('.bxr-bprop-value').removeClass("wrong-bprop");
});

(function (window) {

    if (!!window.JCShareButtons)
    {
            return;
    }

    window.JCShareButtons = function (containerId)
    {
            if (containerId)
            {
                    var container = BX(containerId);
                    if (container)
                    {
                            this.shareButtons = BX.findChildren(container, {tagName: 'LI'}, true);
                            if (this.shareButtons && this.shareButtons.length >= 1)
                            {
                                    BX.bind(this.shareButtons[this.shareButtons.length-1], 'click', BX.delegate(this.alterVisibility, this));
                            }
                    }
            }
    };

    window.JCShareButtons.prototype.alterVisibility = function()
    {
            if (this.shareButtons && this.shareButtons.length >= 1)
            {
                    for (var i = 0; i < this.shareButtons.length-1; i++)
                    {
                            var li = this.shareButtons[i];
                            li.style.display = li.style.display == "none"? "": "none";
                    }
            }
    };
})(window);

function scrollTab() {            
    showTab("SKU");

    if ($('.bxr-detail-tab .avail').length) 
        window.BXReady.scrollTo('.bxr-detail-tab[data-tab="SKU"] .avail');
    else 
        window.BXReady.scrollTo('.bxr-detail-tabs', {offsetTop: 2*40});
};

function showTab(tabCode) {
    $('.bxr-detail-tabs .bxr-detail-tab-div').removeClass('active');
    $('.bxr-detail-tabs .bxr-detail-tab-div[data-tab="'+tabCode+'"]').addClass('active');
    $('.bxr-detail-smart-links li').removeClass('active');
    $('.bxr-detail-smart-links li[data-tab="'+tabCode+'"]').addClass('active');
    if (!$('.bxr-detail-tab[data-tab="'+tabCode+'"]').hasClass("bxr-detail-tab-list") && tabCode && $(window).width() >= 768) {
        $('.bxr-detail-tab').hide();
        $('.bxr-detail-tab[data-tab="'+tabCode+'"]').show(0, function(){
            if(tabCode=="VIDEO")
                $(window).trigger('resizeVideo');
            if(tabCode=="GIFT")
                BXRGiftDetail.resizeVerticalBlock();
        });
    }
}

var videoResizeState = false;

function resizeTabs() {
    if ($(window).width() < 768){
        $('.bxr-detail-tab').css('display', 'block');
    }else{
        tab = $('.bxr-detail-tabs .bxr-detail-tab-div.active').data('tab');
        showTab(tab);
    }
}

$(document).on('click', '.bxr-detail-tabs .bxr-detail-tab-div', function() {
    var tabCode = $(this).data('tab');
    showTab(tabCode);
});

$(document).on('click', '.bxr-detail-smart-links li, .bxr-detail-smart-links-top li', function() {
    var tabCode = $(this).data('tab');
    var tabType = $(this).data('type');

    var tabOffset = 20;
	var h = ~~parseInt($('#bxr-top-fixed-panel').height());
	
    if (tabType == 'all')
		$('html, body').animate({ scrollTop: $('.bxr-detail[data-scroll="'+tabCode+'"]').offset().top-h-tabOffset }, 500);
    else if ($('.bxr-detail-tabs:visible').length > 0)
		$('html, body').animate({ scrollTop: $('.bxr-detail-tabs').offset().top-h-tabOffset }, 500);
    else
		$('html, body').animate({ scrollTop: $('.bxr-detail-tab[data-tab="'+tabCode+'"]').offset().top-h-tabOffset }, 500);

    showTab(tabCode);
});

$(document).on("mouseenter", ".bxr-detail-smart-links li", function(e) {
    self = this;
    $(".bxr-smart-link-tooltip").removeClass("visible");
    $(".bxr-smart-link-tooltip").fadeOut(0);
    $(self).find(".bxr-smart-link-tooltip").fadeIn(0, function() {
        $(self).find(".bxr-smart-link-tooltip").addClass("visible");
    });
});

$(document).on("mouseleave", ".bxr-detail-smart-links li", function(e) {
    $(".bxr-smart-link-tooltip").removeClass("visible");
    $(".bxr-smart-link-tooltip").fadeOut(0);
});

/*start gifts*/
$(document).on('click', '.bxr-gift-notice', function() {
    $('.bxr-detail-tab').hide();
    $('.bxr-detail-tabs .bxr-detail-tab-div').removeClass('active');
    $('.bxr-detail-tabs .bxr-detail-tab-div[data-tab="GIFT"]').addClass('active');
    $('.bxr-detail-tab[data-tab="GIFT"]').show();
    $('html, body').animate({ scrollTop: $(".bxr-detail-tab[data-tab='GIFT']").offset().top-200 }, 500);
});
$(document).on('click', '.bxr-gift-notice,.bxr-detail-top-tabs .bxr-detail-tab-div[data-tab="GIFT"],.bxr-detail-tabs .bxr-detail-tab-div[data-tab="GIFT"]', function() {
    $('.bx_item_list_gift_horizontal').height($('.bx_item_list_gift_horizontal').height());
});

 $(document).ready(function() {
    $('.bxr-sku-select-items').scrollbar();
    $('.scroll-bar').addClass('bxr-color');


    $("ul.sku-prop-values-list-style-select").on("click", ".init", function() {
        $(this).closest("ul").children('li:not(.init)').toggle();
    });

    $("ul.sku-prop-values-list-style-select").on("click", "li:not(.init)", function() {

        $(this).closest("ul").children('.init').html($(this).html()).addClass($(this).attr("class"));
        $(this).closest("ul").children('li:not(.init)').toggle();
    });
	
	if($("#bxr-left-col>ul>li").length<=1) {
		$(".bxr-container-catalog-element").addClass("bxr-not-padding");
		$(".bxr-detail-smart-links").hide();
	}

})

/*end gifts*/

sku = {
    select : function(element) {
        $('ul.bxr-sku-select-items .bxr-sku-select-item').removeClass('active');
        $(element).addClass('active');
    }
}

$(document).on('click', 'ul.bxr-sku-select-items .bxr-sku-select-item', function() { sku.select(this); });