(function() {

    if (!!window.JCCatalogSectionBestseller)
        return;

    window.JCCatalogSectionBestseller = function(params) {
        this.params = params;

        var current = this;

        startElement = $('#bxr-bestsellers div.bxr-bestsellers-group-active');
        activeBestseller = parseInt(startElement.data('slide'));

        if (activeBestseller > 0) {
            this.init();

            if (!this.params.lazyLoad || !BX.browser.IsMobile()) {
                this.load(startElement.data('slide'),startElement.data('type'));
            }
        }

        $(document).on(
            'click',
            '#bxr-bestsellers div.bxr-bestsellers-group',
            function(){
                current.load($(this).data('slide'),$(this).data('type'));
            }
        );

        $(document).on(
            'click',
            '#bxr-bestsellers-container div.bxr-mobile-names',
            function(){
               current.load($(this).data('slide'), 'scroll');
            }
        );
    };

    window.JCCatalogSectionBestseller.prototype =
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

        init: function(){
            prevBtn = '<button type="button" class="bxr-color-button slick-prev hidden-arrow slick-arrow-slim"></button>';
            nextBtn = '<button type="button" class="bxr-color-button slick-next hidden-arrow slick-arrow-slim"></button>';
            $('#bxr-bestsellers div.lent').slick({
                dots: this.params.dots,
                infinite: this.params.infinite,
                speed: this.params.speed,
                slidesToShow: this.params.slidesToShow,
                centerMode: this.params.centerMode,
                variableWidth: this.params.variableWidth,
                prevArrow: prevBtn,
                nextArrow: nextBtn
            });
        },

        load: function(idC, type, mobileMode){
            if (this.params.ajaxUrl.length > 0){

                if ($('#rec_tab'+idC).data('state') != 'load') {
                    $('#rec_tab'+idC).data('state', 'load');

                    targetUrl = this.params.ajaxUrl;
                    BXReady.showAjaxShadow('#bxr-bestsellers-container','bxr-bestsellers-shadow');
                    $.ajax({
                        url: targetUrl,
                        data: {
                            ajax_mode: 'yes',
                            ID: idC,
                            siteId: this.params.postData.siteId,
                            rmT: Math.random(),
                            template: this.params.postData.template,
                            parameters: this.params.postData.parameters
                        },
                        type: 'POST',
                        success: function(data) {
                            BXReady.closeAjaxShadow('bxr-bestsellers-shadow');
                            $('.bxr-bestseller-list').css('display', 'none');
                            $('#best-panel-'+idC).css('display', 'block');
                            $('#best-panel-'+idC).html(data);
                            //BXReady.Market.Basket.refresh(true);
                            //if (typeof window.BXReady.Market.Compare == 'object')
                                //window.BXReady.Market.Compare.reload();
                            if (type == 'scroll') BXReady.scrollTo('#best-panel-'+idC);
                            $('#sl_'+idC).data('slideset', 2);
                        }
                    });
                } else {
                    $('.bxr-bestseller-list').css('display', 'none');
                    $('#best-panel-'+idC).css('display', 'block');
                }
            }
            $('#c'+idC).addClass('active');
            $('.bxr-bestsellers-group').removeClass('bxr-bestsellers-group-active bxr-color bxr-border-color');
            $('#rec_tab'+idC).addClass('bxr-bestsellers-group-active bxr-color bxr-border-color');
        }
    }
})();