"use strict";
(function (jQuery) {

    if (!!window.BXRSEOEditor)
        return;

    window.BXRSEOEditor = function(params){

        this.params = params;
        this.saveMode = false;
    };

    window.BXRSEOEditor.prototype = {

        verifyData: function() {
            return true;
        },

        currentSet: function(){

            var prefix='';

            var _this = this;
            var addUrl = '';

            if (!_this.verifyData()) {
                return ;
            }

            addUrl = addUrl + _this.getDinamicData();

            return {
                active : $('bxr-seo-active-flag').attr('checked') == 'checked' ? 'Y' : "N",
                addUrl: addUrl
            };

        },

        load: function(){

            var setId = this.params.id;

        },

        update: function(){
            var _this = this;

            var id = parseInt($('#seo_set_info').data('set'));
            var fType = $('#seo_set_info').data('ftype');
            var fNav = $('#bxr-seo-selector-nav').prop('checked');

            fType = fType == 'filter' ? 'F' : 'C';
            fNav = fNav ? "Y" : "N";

            if (_this.params.ajaxUrl.length <= 0 || id<=0) return;
            var addUrl = '';

            var action = 'update';
            var ajaxUrl = _this.params.ajaxUrl;
            var ext_params = {
                'navigation' : fNav
            };

            if (fType == 'C') {
                var setData = _this.currentSet();
                var ajaxUrl = _this.params.ajaxUrl;
                ext_params['filter_type'] = $('.bxr-cond-filter input[name="bxr-cond-filter-type"]:checked').val();
                if (setData.addUrl.length > 0) {
                    ajaxUrl = ajaxUrl + '?' + setData.addUrl;
                }
            } else {
                var setData = _this.filterData != 'undefined' ? _this.filterData : {};
            }

            $.ajax({
                url: ajaxUrl,
                data: {
                    ajax: 'yes',
                    action: action,
                    id: id,
                    ftype: fType,
                    IBLOCK_ID: _this.params.iblockId,
                    rg: Math.random(),
                    siteId: _this.params.postData.siteId,
                    template: _this.params.postData.template,
                    parameters: _this.params.postData.parameters,
                    descr: setData,
                    ext_params: ext_params

                },
                type: 'POST',
                success: function(data) {
                    $('#bxr-seo-set').html(data);
                    _this.init();
                    $('#form_element_' + _this.params.iblockId + '_form #save').off(
                        'click'
                    );
                    $('#form_element_' + _this.params.iblockId + '_form #apply').off(
                        'click'
                    );
                    $('#form_element_' + _this.params.iblockId + '_form #save_and_add').off(
                        'click'
                    );
                    $('#form_section_' + _this.params.iblockId + '_form input[name=apply]').off(
                        'click'
                    );
                    $('#form_section_' + _this.params.iblockId + '_form input[name=save]').off(
                        'click'
                    );
                    $('#form_section_' + _this.params.iblockId + '_form input[name=save_and_add]').off(
                        'click'
                    );
                    _this.saveMode = false;
                }
            });
        },

        addFilter: function(filter) {
            this.filterData = filter;
            $('#seo_set_info').data('ftype', 'filter');
            this.activateSave();
            this.update();
        },

        add: function(){

            var _this = this;
            if (_this.params.ajaxUrl.length <= 0) return;

            $.ajax({
                url: _this.params.ajaxUrl,
                data: {
                    ajax: 'yes',
                    action: 'create',
                    rg: Math.random(),
                    siteId: _this.params.postData.siteId,
                    template: _this.params.postData.template,
                    parameters: _this.params.postData.parameters,
                    IBLOCK_ID: _this.iblockId
                },
                type: 'POST',
                success: function(data) {
                    $('#bxr-seo-set').html(data);
                    _this.init();

                }
            });
        },

        delete: function(){
            var _this = this;
            var id = parseInt($('#seo_set_info').data('set'));

            if (_this.params.ajaxUrl.length <= 0 || id<=0) return;


            $.ajax({
                url: _this.params.ajaxUrl,
                data: {
                    ajax: 'yes',
                    action: 'delete',
                    id: id,
                    rg: Math.random(),
                    siteId: _this.params.postData.siteId,
                    template: _this.params.postData.template,
                    parameters: _this.params.postData.parameters
                },
                type: 'POST',
                success: function(data) {
                    $('#bxr-seo-set').html(data);
                    _this.init();

                }
            });
        },

        activateSave: function () {

            var _this = this;

            $('#bxr-seoset-update').removeAttr('disabled').addClass('adm-btn-save');
            if (!this.saveMode){
                $('#form_section_' + _this.params.iblockId + '_form input[name=save]').on(
                    'click',
                    function(){
                        if (confirm(_this.params.confirmMessage)) {

                        } else {
                            return false;
                        }

                    }
                );
                $('#form_section_' + _this.params.iblockId + '_form input[name=apply]').on(
                    'click',
                    function(){
                        if (confirm(_this.params.confirmMessage)) {

                        } else {
                            return false;
                        }

                    }
                );
                $('#form_section_' + _this.params.iblockId + '_form input[name=save_and_add]').on(
                    'click',
                    function(){
                        if (confirm(_this.params.confirmMessage)) {

                        } else {
                            return false;
                        }
                    }
                );

                this.saveMode = true;
            }
        },

        init: function(){

            var _this = this;

            $('#bxr-seoset-add').on(
                'click',
                function(){
                    _this.add();
                    return false;
                }
            );

            $('#bxr-seoset-delete').on(
                'click',
                function(){
                    if (confirm(_this.params.Messages.confirmDelete)) {
                        _this.delete();
                    }

                    return false;
                }
            );

            $('#bxr-seoset-update').on(
                'click',
                function(){
                    _this.update();
                    return false;
                }
            );

            $('#cond_seoset').find('input, select').on(
                'change',
                function(){
                    _this.activateSave();

                }
            );

            $('#bxr-seo-selector').on(
                'change',
                function(){
                    if ($(this).prop('checked')) {
                        $('.bxr-seo-set-body').addClass('active');
                        _this.toggleActivate(true);

                    } else {
                        $('.bxr-seo-set-body').removeClass('active');
                        _this.toggleActivate(false);
                    }
                }
            );

            $('.filter-type-radio input[name=bxr-filter-type]').on(
                'change',
                function(){
                    if ($(this).val() == 'filter') {
                        $('#seo_set_info').data('ftype', 'filter');
                        $('#bxr-seo-cond-panel').hide();
                        $('#bxr-seo-filter-panel').show();
                    } else {
                        $('#seo_set_info').data('ftype', 'condition');
                        $('#bxr-seo-cond-panel').show();
                        $('#bxr-seo-filter-panel').hide();
                    }
                }
            );

            $('.bxr-cond-filter input[name=bxr-cond-filter-type]').on(
                'change',
                function(){
                    _this.activateSave();
                }
            );

            $('#bxr-cond-filter, #bxr-seo-selector-nav').on(
                'change',
                function(){
                    _this.activateSave();
                }
            );

            $('#bxr-seoset-filter').on(
                'click',
                function() {
                    var addUrl = $('#add_filter_string').text();
                    var showUrl = _this.params.urlSmartFilter + addUrl;
                    jsUtils.OpenWindow(showUrl, 380, 500);
                }
            );

            BX.addCustomEvent('onTreeCondPopupClose', function(){
                _this.activateSave();
            });

            BX.addCustomEvent('onNextVisualChange', function(){
                _this.activateSave();
            });
        },

        toggleActivate: function(activeFlag) {
            var _this = this;
            if (_this.params.ajaxUrl.length <= 0) return;
            var state = activeFlag ? "Y" : "N";
            var id = parseInt($('#seo_set_info').data('set'));

            $.ajax({
                url: _this.params.ajaxUrl,
                data: {
                    ajax: 'yes',
                    action: 'activate',
                    state: state,
                    IBLOCK_ID: _this.params.iblockId,
                    id: id,
                    rg: Math.random(),
                    siteId: _this.params.postData.siteId,
                    template: _this.params.postData.template,
                    parameters: _this.params.postData.parameters
                },
                type: 'POST',
                success: function(data) {
                    $('#bxr-seo-set').html(data);
                    _this.init();

                }
            });
        },

        getDinamicData: function() {

            var dinamicData = '';
            var prefix = '';
            var id = 'seoset';

            $('#cond_'+id).find('input, select').each(function(){
                var name = $(this).attr('name');
                if (name != undefined){
                    if (name.indexOf('COND_'+id+'[') + 1 || name == 'current_condition_'+id || name == 'current_condition_ch_'+id){
                        dinamicData += prefix+encodeURIComponent(name) + '=' + $(this).val();
                        prefix = '&';
                    }
                }

            });
            return dinamicData;
        }
    }

})(jQuery);