(function() {

    if (!!window.JCOneClickOrderBasket)
        return;

    window.JCOneClickOrderBasket = function(params) {
        this.params = params;

        var current = this;
    };

    window.JCOneClickOrderBasket.prototype =
        {
            load: function(e){
                window.BXReady.showAjaxShadow("#ajaxFormContainer_oco", "ajaxFormContainer_oco");
                BX.ajax.submit(BX("" + this.params.formId),function(data){                    
                    window.BXReady.closeAjaxShadow("ajaxFormContainer_oco");
                    dataInc = data.replace(/<div[^>]+>/gi, ''); 
                    dataInc = dataInc.replace('</div>', '');  
                    location.href = dataInc;
                });

                return false;
            }
        }
})();