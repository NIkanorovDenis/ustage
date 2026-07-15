(function() {
    if (!!window.JCCatalogCompareSlider)
        return;

    window.JCCatalogCompareSlider = function(params) {
        this.prevBtn;
        this.nextBtn;
        BXReady.showAjaxShadow('#sl_'+params.uniqId, 'shadow_slider_'+params.uniqId);

        $('#sl_'+params.uniqId).on('init', function(event, slick){
            var currentSlide = params.initialSlide;
            var side = $(event.currentTarget).data('side');
            var itemId = $(slick['$slides'][currentSlide]).data('item');
            showProps(side, itemId);
            hideSimilar();
        });

        $('#sl_'+params.uniqId).slick({
            initialSlide: params.initialSlide,
            dots: false,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            swipe: false,
            touchMove: false,
            lazyLoad: 'ondemand'
        });
        BXReady.closeAjaxShadow('shadow_slider_'+params.uniqId);

        $('#sl_'+params.uniqId).on('afterChange', function(event, slick, currentSlide){
            var side = $(event.currentTarget).data('side');
            var itemId = $(slick['$slides'][currentSlide]).data('item');
            showProps(side, itemId);
            hideSimilar();
        });
    };

    function showProps(side, itemId) {
        $('.bxr-compare-property-value-td-'+side).each(function() {
            $(this).find('.bxr-compare-property-value').hide();
            $(this).find('.bxr-compare-property-value[data-item="' + itemId + '"]').show();
        });
    };

    function hideSimilar() {
        $('.bxr-compare-only-diff .bxr-compare-property-name-tr').show();
        $('.bxr-compare-only-diff .bxr-compare-property-value-tr').show();
        $('.bxr-compare-only-diff .bxr-compare-property-value-tr').each(function() {
            var leftHtml = $(this).find('.bxr-compare-property-value-td-left>div:visible').html();
            var rightHtml = $(this).find('.bxr-compare-property-value-td-right>div:visible').html();
            if (leftHtml == rightHtml && $(this).find('.bxr-compare-property-value-td-right').length) {
                $(this).hide();
                $(this).prev().hide();
            } else {
                $(this).show();
                $(this).prev().show();
            }
        });
    }

    $(document).on("click", ".bxr-compare-slick-button-next", function() {
        var currenSlideDiv = $(this).closest('.bxr-compare-dots').find(".bxr-compare-current-slide");
        var currenSlide = parseInt($(currenSlideDiv).html());
        var nextSlide = currenSlide + 1;
        var maxSlide = parseInt($(this).data("max"));
        if (nextSlide <= maxSlide)
            $(currenSlideDiv).html(nextSlide);
        $(this).closest(".bxr-compare-slider-col").find(".slick-next").trigger("click");
    });

    $(document).on("click", ".bxr-compare-slick-button-prev", function() {
        var currenSlideDiv = $(this).closest('.bxr-compare-dots').find(".bxr-compare-current-slide");
        var currenSlide = parseInt($(currenSlideDiv).html());
        var prevSlide = currenSlide - 1;
        if (prevSlide > 0)
            $(currenSlideDiv).html(prevSlide);
        $(this).closest(".bxr-compare-slider-col").find(".slick-prev").trigger("click");
    })
})();