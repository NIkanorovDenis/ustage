(function (jQuery) {

    if (!!window.BXR24FiterPreset)
        return;

    window.BXR24FiterPreset = function(params){

        this.params = params;

    };

    window.BXR24FiterPreset.prototype = {

        init: function() {

            var id = parseInt(this.params.id);

            if (id > 0) {
                this.loadData();
            };

        },

        loadData: function(cross) {

            var _this = this;

            $.ajax({
                url: _this.params.ajaxUrl,
                data: {
                    ajax_mode: 'yes',
                    siteId: _this.params.postData.siteId,
                    rg: Math.random(),
                    template: _this.params.postData.template,
                    parameters: _this.params.postData.parameters,
                    BID: _this.params.id,
                    UID: _this.params.uid
                },
                type: 'POST',
                success: function(data) {
                    $('#bxr24_block_view_'+_this.params.uid).html(data);
                }
            });

        }
    }


})(jQuery);