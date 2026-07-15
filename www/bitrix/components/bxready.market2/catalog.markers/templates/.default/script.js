(function() {
    if (!!window.JCCatalogSectionMarkers)
        return;

    window.JCCatalogSectionMarkers = function(params) {

        this.params = params;
        var current = this;

        activeMarker = this.params.first;
        startElement = $('#marc_tab'+this.params.first);

        this.init();

        if (!this.params.lazyLoad || !BX.browser.IsMobile()) {
            this.load(startElement.data('slide'),startElement.data('type'));
        }

        $(document).on(
            'click',
            '#bxr-markers div.bxr-markers-group',
            function(){
                current.load($(this).data('slide'),$(this).data('type'));
            }
        );

        $(document).on(
            'click',
            '#bxr-markers-container div.bxr-marker-mobile-names',
            function(){
               current.load($(this).data('slide'), 'scroll');
            }
        );
    };

    window.JCCatalogSectionMarkers.prototype =
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

        },

        load: function(idC, type, mobileMode){
            if (this.params.ajaxUrl.length > 0) {
                if ($('#marc_tab'+idC).data('state') != 'load') {
                    $('#marc_tab'+idC).data('state', 'load');

                    targetUrl = this.params.ajaxUrl;
                    BXReady.showAjaxShadow('#bxr-markers-container','bxr-markers-shadow');
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
                            BXReady.closeAjaxShadow('bxr-markers-shadow');
                            $('.bxr-markers-list').css('display', 'none');
                            $('#mark-panel-'+idC).css('display', 'block');
                            $('#mark-panel-'+idC).html(data);
                            //BXReady.Market.Basket.refresh(true);
                            if (typeof window.BXReady.Market.Compare == 'object')
                                window.BXReady.Market.Compare.reload();
                            if (type == 'scroll') BXReady.scrollTo('#mark-panel-'+idC);
                            $('#sl_'+idC).data('slideset', 2);
                        }
                    });
                } else {
                    $('.bxr-markers-list').css('display', 'none');
                    $('#mark-panel-'+idC).css('display', 'block');
                }
            }
            $('#c'+idC).addClass('active');
            $('.bxr-markers-group').removeClass('bxr-markers-group-active');
            $('#marc_tab'+idC).addClass('bxr-markers-group-active');
        }
    }
})();