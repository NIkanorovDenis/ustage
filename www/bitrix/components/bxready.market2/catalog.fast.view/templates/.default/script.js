(function() {

    if (!!window.JCCatalogFastView)
        return;

    window.JCCatalogFastView = function(params) {
        this.params = params;
        
        var current = this;

        this.init();

        $(document).on("click", ".bxr-fast-view-btn", function(event){
            current.load(event.target)}
        );

        $(document).on("show.bs.modal", "#fv_fastview", function(){
                current.clearData();
            }
        );


    };

    window.JCCatalogFastView.prototype =
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

        load: function(e){

            this.clearData();

            var id = $(e).data("uid");
            //var formBodyId = $(e).data("form-id");
            var formBodyId = 'ajaxFormContainer_fastview';
            var elementId = $(e).data("element-id");
            var offerId = $(e).data("offer-id");
            var sectionId = $(e).data("section-id");
            var elementUrl = $(e).data("element-url");
            
            //$('body').append($('#fv_'+id));
            if (this.params.ajaxUrl.length > 0) {
                if ($('#bxr-fast-view-btn-'+id).data('state') != 'load') {
                    $('#bxr-fast-view-btn-'+id).data('state', 'load');
                    targetUrl = this.params.ajaxUrl;

                    $.ajax({
                        url: targetUrl,
                        data: {
                            ajax_mode: 'yes',
                            ID: id,
                            siteId: this.params.postData.siteId,
                            rmT: Math.random(),
                            template: this.params.postData.template,
                            parameters: this.params.postData.parameters,
                            elementId : elementId,
                            offerId : offerId,
                            sectionId : sectionId,
                            elementUrl : elementUrl
                        },
                        type: 'POST',
                        success: function(data) {
                            $('#'+formBodyId).html(data);
                            var productName = $('#'+formBodyId).find('.bxr-name-wrap');
                            $('#'+formBodyId).closest('.fast-view-modal').find('.modal-title').html(productName);
                        }
                    });
                } else {
                    
                }
            }
        },

        clearData: function(){
            clearHtml = '<div class="bxr-modal-loading"><i class="fa fa-circle-o-notch fa-spin bxr-font-color" aria-hidden="true"></i></div>';
            $('#ajaxFormContainer_fastview').html(clearHtml);
            $('#fv_fastview .modal-title').html('Fast View loaded....');

        }
    }
})();