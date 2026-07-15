(function (jQuery) {
    if (!!window.gearBXR24Control)
        return;

    window.gearBXR24Control = function (params) {
        this.params = params;
        this.params.selected = {};
        this.changeTab(this.params.currentTab);
    };

    window.gearBXR24Control.prototype = {

        gearTabs: undefined,
        gearBlocks: undefined,
        needReload: 0,


        init: function () {
            var _this = this;
            _this.initButtons();
            if (_this.params.downloadAjax) {
                _this.initButtonsAfterAjax();
            }

            $('.btn-start ').hover(
                function () {
                    $('.btn-start .fa')
                        .removeClass('fa-cogs')
                        .addClass('fa-gear')
                        .addClass('fa-spin');

                },
                function () {
                    $('.btn-start .fa')
                        .removeClass('fa-spin')
                        .removeClass('fa-gear')
                        .addClass('fa-cogs')

                }
            )
        },

        downloadContent: function () {
            var _this = this;
            _this.reload('lazy');
        },

        initButtons: function () {
            var _this = this;
            $('.btn-start').on(
                'click',
                function () {
                    if (_this.params.downloadAjax === false) {
                        $('.btn-start .fa').addClass('fa-spinner');
                        $('.btn-start .fa').addClass('fa-spin');

                        _this.downloadContent();
                    } else {
                        _this.showPanel();
                    }
                }
            );
            $('.btn-def').on(
                'click',
                function () {
                    _this.reset();
                }
            );
        },

        showPanel: function () {
            $('.gear').toggleClass('show');
        },

        initButtonsAfterAjax: function () {

            var _this = this;

            $('#gearBXR24 .template-box').on(
                'click',
                function () {
                    var id = $(this).data('item');
                    var selector = $(this).data('parent');
                    _this.params.selected[selector] = id;
                    $('.template-box[data-parent=' + selector + ']').removeClass('active');
                    $(this).addClass('active');
                    _this.needReload++;
                    setTimeout(_this.params.objName + '.initReload()', _this.params.timeReload);
                }
            );

            $('#gearBXR24 .gear-tab').on(
                'click',
                function () {
                    var id = $(this).data('item');
                    if (id.length > 0) {

                        _this.changeTab(id);
                    }
                }
            );

            $('.gear-main').scrollbar();

            $("#color_picker").spectrum({
                preferredFormat: "hex",
                showInput: true
            });

            $('.option-input.radio').on(
                'change',
                function () {
                    var selector = $(this).attr('name');
                    var value = $(this).val();
                    _this.params.selected[selector] = '#' + value;
                    _this.needReload++;
                    setTimeout(_this.params.objName + '.initReload()', _this.params.timeReload);
                }
            );

            var isMouseDown = false;

            $('.sp-val').mousedown(function () {
                isMouseDown = true;
            });

            $('.sp-val').mouseup(function () {
                isMouseDown = false;
            });
            $('.sp-val').on('mousemove', function () {

                if (isMouseDown) {
                    $('.sp-replacer').css('background', $('.sp-input').val());
                    $('.sp-replacer').css('border-color', $('.sp-input').val());
                    $('.sp-dd').css('color', 'transparent');

                }
            });

            $('.sp-choose').on('click', function () {
                $('.sp-preview-inner').css('background-color', $('.sp-input').val());
                $('.sp-dd').css('color', '#ffffff');
                $(".color input:radio:checked").prop('checked', false);
                var selector = $('#color_picker').attr('name');
                var value = $('#color_picker').val();
                _this.params.selected[selector] = value;
                _this.needReload++;
                setTimeout(_this.params.objName + '.initReload()', _this.params.timeReload);
            });

            $('.text-select input').on(
                'change',
                function () {
                    _this.needReload++;
                    var name = $(this).attr('name');
                    var id = $(this).attr('id');
                    _this.params.selected[name] = id;
                    setTimeout(_this.params.objName + '.initReload()', _this.params.timeReload);
                }
            );

            $('.checkbox-selector').on(
                'change',
                function () {
                    _this.needReload++;
                    var name = $(this).attr('name');
                    var val = $(this).prop('checked') ? 'on' : 'off';
                    _this.params.selected[name] = name + '_' + val;
                    setTimeout(_this.params.objName + '.initReload()', _this.params.timeReload);
                }
            );

            $('.btn-share').click(_this.openShare);
            $('.btn-document').click(_this.openDoc);

            $('.btn-document, .btn-share').click(_this.hideBtn);

            $('.share-copylink').click(function () {
                var copyInput = $('.share-copyinput');
                copyInput.text();
                copyInput.focus();
                copyInput.select();
                    document.execCommand('copy');
                    $(".copied").text("Текст скопирован").show().fadeOut(1200);
                });



            if (window.pluso) if (typeof window.pluso.start == "function") return;
            if (window.ifpluso == undefined) {
                window.ifpluso = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript';
                s.charset = 'UTF-8';
                s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
                var h = d[g]('body')[0];
                h.appendChild(s);
            }

            if ($('.gear-tabs').height() >= 768){

                $('.gear-tabs').css('position', 'static');
                $('.gear-content').css('margin-left', 0);
            }
        },

        openShare: function () {
            $('.gear-share').addClass('show');
            $('.btn-close-share').click(function () {
                $('.gear-share').removeClass('show');
                $('.gearbuttons').show();

            });

        },

        openDoc: function () {
            $('.gear-document').addClass('show');
            $('.btn-close-document').click(function () {
                $('.gear-document').removeClass('show');
                $('.gearbuttons').show();

            });
        },

        hideBtn: function () {
            $('.gearbuttons').hide();
        },

        changeTab: function (id) {
            var _this = this;
            var allTabs = _this.gearTabs != undefined ? _this.gearTabs : $('.gear-tab');
            allTabs.each(function () {
                var ids = $(this).data('item');
                if (ids == id) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            });
            var allTabs = _this.gearBlocks != undefined ? _this.gearBlocks : $('.gear-block');
            allTabs.each(function () {
                var ids = $(this).data('item');
                if (ids == id) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            });
            this.params.currentTab = id;
        },

        reload: function (action) {
            _this = this;

            if (action == undefined) {
                action = 'set'
            }

            var ajaxUrl = _this.params.ajaxUrl;
            if (ajaxUrl.length > 0) {
                $.ajax({
                    url: ajaxUrl,
                    data: {
                        ajax_mode: 'yes',
                        rg: Math.random(),
                        siteId: _this.params.postData.siteId,
                        template: _this.params.postData.template,
                        parameters: _this.params.postData.parameters,
                        siteTemplate: _this.params.postData.siteTemplate,
                        action: action,
                        selected: this.params.selected,
                        tab: this.params.currentTab,
                        sessid: this.params.sessid
                    },
                    type: 'POST',
                    success: function (data) {

                        if (action == 'lazy') {
                            $('#gearBXR24 .gear-main').html(data);

                            $('.btn-start .fa').removeClass('fa-spinner');
                            $('.btn-start .fa').removeClass('fa-spin');

                            _this.initButtonsAfterAjax();
                            _this.params.downloadAjax = true;
                            _this.showPanel();
                        } else {
                            if (data != 'error') {
                                location.reload();
                            }
                        }

                    }
                });
            }
        },

        reset: function () {
            this.reload('reset');
        },

        initReload: function () {
            this.needReload--;
            if (this.needReload <= 0) {
                this.reload();
            }
        }
    };
})(jQuery);