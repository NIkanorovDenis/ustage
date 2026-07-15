(function() {

    var BXRFixedPanelCreate = false,
    BXRFixedPanelTop = 99999999;

    if (!!window.JCTopFixedPanelAjax)
        return;

    window.JCTopFixedPanelAjax = function(params) {
        this.params = params;
        
        var BXRFixedPanel = this;


        $(document).scroll(function(){

            if ($(window).width() < BXRFixedPanel.params.mWidth){
                BXRFixedPanel.hide();
                return;
            }

            if ($(document).scrollTop() > BXRFixedPanelTop){
                BXRFixedPanel.show();
            }else{
                BXRFixedPanel.hide();
            }

        });

        $(window).resize(function(){
            if ($(window).width() < BXRFixedPanel.params.mWidth){
                BXRFixedPanel.hide();
                return;
            }
        });

        BXRFixedPanel.init();

    };

    window.JCTopFixedPanelAjax.prototype =
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



            if (!BXRFixedPanelCreate){

                params ={
                    'siteId' : this.params.siteId,
                    'template' : this.params.templateID,
                    'parameters' : this.params.parameters,
                    'bxmarket' : this.params.bxmarket,
                    'rg': Math.random()
                }

                request = $.ajax({
                    url:  this.params.ajaxUrl,
                    data: params,
                    type: 'POST',
                    success: function(data){
                        $('#bxr-top-fixed-panel').html(data);
                        BXRFixedPanelTop = $('#bxr-top-fixed-panel-anker').position().top;
                        $('#bxr-top-fixed-panel').trigger('onCreateFixedPanel');
                        BXRFixedPanelCreate = true;
                    }
                });


            };

        },

        show: function(){
            if ($('#bxr-top-fixed-panel').data('show') != '1'){

                $('#bxr-top-fixed-panel').fadeIn(200);
                $('#bxr-top-fixed-panel').data('show', '1');
                $('#bxr-top-fixed-panel').trigger('onShowFixedPanel');
            }
        },

        hide: function(){
            if ($('#bxr-top-fixed-panel').data('show') != '0'){
                $('#bxr-top-fixed-panel').fadeOut(200);
                $('#bxr-top-fixed-panel').data('show', '0');
                $('#bxr-top-fixed-panel').trigger('onHideFixedPanel');
            }
        }
    }
})();