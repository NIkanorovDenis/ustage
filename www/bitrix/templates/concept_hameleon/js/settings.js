function minHeightEditSets(thisblock, height, height1, height2) {
    if (height2 === "NULL")
        height2 = 0;

    var total = height - height1 - height2;

    thisblock.find('table.sides').css('min-height', total + 'px');

    

}

function showHideOptions(check, block, type) {

    if (type == 'checkbox') {
        if (check.prop("checked"))
            block.slideDown(200);

        else{
            block.slideUp(200);
        }
    }

    else if (type == 'radio') {
        if (!block.hasClass('active')) {
            check.parents('.parent-more-option').next().find('.more-option').removeClass('active');
            block.addClass('active');
            check.parents('.parent-more-option').next().find('.more-option').slideUp(200);
        }

        block.slideDown(200);

    }

    else if (type == 'open')
        block.slideDown(200);

    else if (type == 'close')
        block.slideUp(200);

    
}


$(document).ready(
    function() {

        function showTooltip(elem, msg) {
            $(elem).parents(".parent_copy").find(".copy-success").addClass("active");
            var timeOut = setTimeout(
                function() {
                    $(elem).parents(".parent_copy").find(".copy-success").removeClass("active");
                    clearTimeout(timeOut);
                }, 3000
            );
        }

        $.farbtastic('#picker_head_bg_color').linkTo('#head_bg_color');
        $.farbtastic('#menu_bg_color_panel').linkTo('#menu_bg_color');
        $.farbtastic('#panel_hameleon_user_color').linkTo('#picker_hameleon_user_color');
        $.farbtastic('#picker_body_bg_clr').linkTo('#body_bg_clr');
        $.farbtastic('#picker_footer_bg_clr').linkTo('#footer_bg_clr');


        var clipboardDemos = new Clipboard(".list-copy");

        clipboardDemos.on('success', function(e) {
            e.clearSelection();
            console.log(e);
            showTooltip(e.trigger);
        });
        clipboardDemos.on('error', function(e) {;});

        var menu_open = BX.getCookie('_hameleon_menu_open_' + $("input#current_landing_id").val());

        if (menu_open == 'Y') {
            if (typeof($('div.tool-settings')) != "undefined")
                $('div.tool-settings').addClass('on');

            if (typeof($('.change-colls')) != "undefined")
                $('.change-colls').addClass('on');

            $('div.hameleon-main-setting').addClass('off');
            var timeOut = setTimeout(
                function() {
                    $('.hameleon-main-setting').addClass('hide');
                    clearTimeout(timeOut);
                }, 500

            );

            $('div.hameleon-sets-list-wrap').addClass('on');
            var timeOut2 = setTimeout(
                function() {
                    $('div.hameleon-sets-list-wrap.on').addClass('view');
                    clearTimeout(timeOut2);
                }, 50

            );

            $("a.tool-settings").addClass("active");
        }
        else {
            if (typeof($('div.tool-settings')) != "undefined")
                $('div.tool-settings').removeClass('on');

            if (typeof($('.change-colls')) != "undefined")
                $('.change-colls').removeClass('on');

            $('div.hameleon-sets-list-wrap').removeClass('view');
            var timeOut = setTimeout(
                function() {
                    $('div.hameleon-sets-list-wrap').removeClass('on');
                    clearTimeout(timeOut);
                }, 200
            );

            $('div.hameleon-main-setting').removeClass('hide');

            var timeOut2 = setTimeout(
                function() {
                    $('div.hameleon-main-setting').removeClass('off');
                    clearTimeout(timeOut2);
                }, 200
            );

            $("a.tool-settings").removeClass("active");
        }

    }
);


/*setting file-download*/
$(document).on("click", ".clearfile",
    function() {
        $(this).parents(".clearfile-parent").find('input.hameleon_file_del').val('Y');
        $(this).parents(".clearfile-parent").find('.focus-anim').removeClass('focus-anim');
        $(this).parents(".clearfile-parent").find('.ex-file').html('');
        $(this).removeClass('on');
        $(this).parents(".clearfile-parent").find('input[type="file"]').val('');

        
    }
);


$(document).on("click", "div.set-content input[type='file']",
    function() {
        var inp = $(this);
        var btn = inp.parent();
        var lbl = btn.find("span.ex-file");
        var file_api = (window.File && window.FileReader && window.FileList && window.Blob) ? true : false;

        inp.change(
            function() {
                var file_name;

                if (file_api && inp[0].files[0])
                    file_name = inp[0].files[0].name;
                else{
                    file_name = inp.val().replace("C:\\fakepath\\", '');
                }

                if (!file_name.length)
                    return;

                if (lbl.is(":visible")) {
                    lbl.text(file_name);

                }
                else{
                    btn.text(file_name);
                }

                btn.addClass('focus-anim');

                inp.parents(".clearfile-parent").find(".clearfile").addClass('on');

            }
        ).change();
        
    }
);


/*send form*/
$(document).on("submit", "form.form-setting",
    function() {

        var form = $(this);

        var formData = new FormData(form.get(0));
        formData.append("send", "Y");

        var button = $("button#form-submit", form);

        var load = $("div.load", form);
        var thank = $("div.thank", form);


        var error = 0;
        var count = 0;

        $("input.email", form).each(
            function() {
                /*if($(this).val().length > 0)
                {
                    if(!(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test($(this).val()))
                    {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                        
                        count++;
                    }
                }*/

                if (count == 1) {
                    var destination = $(this).position().top;

                    if (destination <= 0)
                        destination = 0;

                    jQuery("div.hameleon-setting.list-set.on").animate({
                        scrollTop: destination
                    }, 700);
                }

            }
        );
        $("input[type='text'], input[type='password'], textarea", form).each(
            function(key, value) {

                /*if($(this).hasClass("email") && $(this).val().length > 0)
                {
                    if(!(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test($(this).val()))
                    {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                    }
                }*/


                if ($(this).hasClass("require")) {
                    if ($(this).val().length <= 0) {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                    }
                }
            }
        );


        if (error == 0) {
            button.parents("div.part-cell").width(button.parents("div.part-cell").width());

            button.removeClass("active");
            load.addClass("active");


            $.ajax({

                url: "/bitrix/templates/concept_hameleon/ajax/settings.php",
                type: "post",
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                success: function(json) {

                    /*$("body").append(json);*/

                    if (json.OK == "N") {
                        button.addClass("active");
                        load.removeClass("active");

                    }

                    if (json.OK == "Y") {
                        if (json.HREF == "0")
                            location.href = location.href;
                        else{
                            location.href = json.HREF;
                        }
                    }



                }
            });


        }

        return false;

    }
);


$(document).on("submit", "form.form-page-list",
    function() {

        var form = $(this);

        var formData = new FormData(form.get(0));
        formData.append("send", "Y");

        var button = $("button#form-submit", form);

        var load = $("div.load", form);
        var thank = $("div.thank", form);


        var error = 0;
        var count = 0;

        if (error == 0) {
            button.parents("div.part-cell").width(button.parents("div.part-cell").width());

            button.removeClass("active");
            load.addClass("active");


            $.ajax({

                url: "/bitrix/templates/concept_hameleon/ajax/page-list.php",
                type: "post",
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                success: function(json) {

                    if (json.OK == "N") {
                        button.addClass("active");
                        load.removeClass("active");

                    }

                    if (json.OK == "Y")
                        location.href = location.href;


                }
            });


        }

        return false;

    }
);


/*send form*/
$(document).on("submit", "form.form-add-page",
    function() {

        var form = $(this);

        var formData = new FormData(form.get(0));
        formData.append("send", "Y");

        var button = $("button#form-submit", form);

        var load = $("div.load", form);
        var thank = $("div.thank", form);


        var error = 0;
        var count = 0;

        $("input.email", form).each(
            function() {
                /*if($(this).val().length > 0)
                {
                    if(!(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test($(this).val()))
                    {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                        
                        count++;
                    }
                }*/

                if (count == 1) {
                    var destination = $(this).position().top;

                    if (destination <= 0)
                        destination = 0;

                    jQuery("div.hameleon-setting.list-set.on").animate({
                        scrollTop: destination
                    }, 700);
                }

            }
        );
        $("input[type='text'], input[type='password'], textarea", form).each(
            function(key, value) {

                /*if($(this).hasClass("email") && $(this).val().length > 0)
                {
                    if(!(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test($(this).val()))
                    {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                    }
                }*/


                if ($(this).hasClass("require")) {
                    if ($(this).val().length <= 0) {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                    }
                }
            }
        );


        if (error == 0) {
            button.parents("div.part-cell").width(button.parents("div.part-cell").width());

            button.removeClass("active");
            load.addClass("active");


            $.ajax({

                url: "/bitrix/templates/concept_hameleon/ajax/add-page.php",
                type: "post",
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                success: function(json) {

                    if (json.OK == "N") {
                        button.addClass("active");
                        load.removeClass("active");

                    }

                    if (json.OK == "Y")
                        location.href = json.HREF;



                }
            });


        }

        return false;

    }
);

/*send form*/
$(document).on("submit", "form.form-seo",
    function() {

        var form = $(this);

        var formData = new FormData(form.get(0));
        formData.append("send", "Y");

        var button = $("button#form-submit", form);

        var load = $("div.load", form);
        var thank = $("div.thank", form);


        var error = 0;
        var count = 0;

        $("input.email", form).each(
            function() {
                /*if($(this).val().length > 0)
                {
                    if(!(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test($(this).val()))
                    {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                        
                        count++;
                    }
                }*/

                if (count == 1) {
                    var destination = $(this).position().top;

                    if (destination <= 0)
                        destination = 0;

                    jQuery("div.hameleon-setting.list-set.on").animate({
                        scrollTop: destination
                    }, 700);
                }

            }
        );
        $("input[type='text'], input[type='password'], textarea", form).each(
            function(key, value) {

                /*if($(this).hasClass("email") && $(this).val().length > 0)
                {
                    if(!(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test($(this).val()))
                    {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                    }
                }*/


                if ($(this).hasClass("require")) {
                    if ($(this).val().length <= 0) {
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                    }
                }
            }
        );


        if (error == 0) {
            button.parents("div.part-cell").width(button.parents("div.part-cell").width());

            button.removeClass("active");
            load.addClass("active");


            $.ajax({

                url: "/bitrix/templates/concept_hameleon/ajax/seo.php",
                type: "post",
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                success: function(json) {

                    if (json.OK == "N") {
                        button.addClass("active");
                        load.removeClass("active");

                    }

                    if (json.OK == "Y") {
                        location.href = location.href;

                    }



                }
            });


        }

        return false;

    }
);

// new sctipts


$(document).on("click", "div.hameleon-btn",
    function() {

        if (typeof($('div.tool-settings')) != "undefined")
            $('div.tool-settings').addClass('on');

        if (typeof($('.change-colls')) != "undefined")
            $('.change-colls').addClass('on');

        $('div.hameleon-main-setting').addClass('off');
        var timeOut = setTimeout(
            function() {
                $('.hameleon-main-setting').addClass('hide');
                clearTimeout(timeOut);
            }, 500

        );

        $('div.hameleon-sets-list-wrap').addClass('on');
        var timeOut2 = setTimeout(
            function() {
                $('div.hameleon-sets-list-wrap.on').addClass('view');
                clearTimeout(timeOut2);
            }, 50

        );

        $("a.tool-settings").addClass("active");

        BX.setCookie('_hameleon_menu_open_' + $("input#current_landing_id").val(), 'Y', {
            expires: 60 * 60 * 60 * 60
        });


        

    }
);

$(document).on("click", "div.hameleon-sets-list-close",
    function() {
        if (typeof($('div.tool-settings')) != "undefined")
            $('div.tool-settings').removeClass('on');

        if (typeof($('.change-colls')) != "undefined")
            $('.change-colls').removeClass('on');

        $('div.hameleon-sets-list-wrap').removeClass('view');
        var timeOut = setTimeout(
            function() {
                $('div.hameleon-sets-list-wrap').removeClass('on');
                clearTimeout(timeOut);

            }, 200
        );

        $('div.hameleon-main-setting').removeClass('hide');

        var timeOut2 = setTimeout(
            function() {
                $('div.hameleon-main-setting').removeClass('off');
                clearTimeout(timeOut2);
            }, 200
        );

        $("a.tool-settings").removeClass("active");

        BX.setCookie('_hameleon_menu_open_' + $("input#current_landing_id").val(), 'N', {
            expires: 60 * 60 * 60 * 60
        });
        
    }
);

$(document).on("click", "a.hameleon-sets-open",
    function() {
        var attr = $(this).attr('data-open-set');


        $('body').addClass('modal-open');
        $('.wrapper').addClass('blur');
        $('div.hameleon-sets-list-wrap').addClass('blur');
        $('div.sets-shadow').addClass('on');



        $('div.hameleon-setting.' + attr).addClass('open');
        var timeOut = setTimeout(
            function() {
                $('div.hameleon-setting.' + attr).addClass('on');
                minHeightEditSets($('div.hameleon-setting.' + attr), $('div.hameleon-setting.' + attr).height(), $('div.hameleon-setting.' + attr).find('.hameleon-set-head').outerHeight(), $('div.hameleon-setting.' + attr).find('.hameleon-set-top').outerHeight());
                clearTimeout(timeOut);
            }, 200
        );

        
    }
);

$(document).on("click", ".hameleon-set-close",
    function() {
        var btn = $(this);

        if (!(btn.parents('div.hameleon-setting')).hasClass('newpage')) {
            $('body').removeClass('modal-open');
            $('.wrapper').removeClass('blur');
            $('div.hameleon-sets-list-wrap').removeClass('blur');
            $('div.sets-shadow').removeClass('on');
        }



        btn.parents('div.hameleon-setting').removeClass('on');
        var timeOut = setTimeout(
            function() {
                btn.parents('div.hameleon-setting').removeClass('open');
                clearTimeout(timeOut);
            }, 700
        );

        
    }
);


$(document).on('click', 'ul.set-tabs li:not(.active)',
    function() {
        $(this).parents('ul.set-tabs').find('li').removeClass('active');
        $(this).addClass('active');
        $(this).parents('.sides').find('.set-content').removeClass('active');
        $(this).parents('.sides').find('.set-content[data-set="' + $(this).attr('data-set') + '"]').addClass('active');

        
    }
);

$(document).on("click", ".open_edit",
    function() {
        $(this).parents('div.button-wrap').addClass('off');
        $(this).parents('div.hameleon-set-content').find('div.more_edit').addClass('on');
        $(this).parents('div.hameleon-set-content').find('div.more_set').addClass('on');

        
    }
);

$(document).on("click", ".close_edit",
    function() {
        $(this).parents('div.more_edit').removeClass('on');
        $(this).parents('div.hameleon-set-content').find('div.button-wrap').removeClass('off');
        $(this).parents('div.hameleon-set-content').find('div.more_set').removeClass('on');

        
    }
);

$(document).on("click", "span.toggle-indicator",
    function() {
        if ($(this).parents('div.ignite').hasClass('on')) {
            $(this).parents('form.form-page-list').find('input[name="page_active' + $(this).attr('data-page-id') + '"]').val('N');
            $(this).parents('div.ignite').removeClass('on');
        }

        else {
            $(this).parents('form.form-page-list').find('input[name="page_active' + $(this).attr('data-page-id') + '"]').val('Y');
            $(this).parents('div.ignite').addClass('on');
        }

        
    }
);

$(document).on("click", "a.new_page",
    function() {
        var attr = $(this).attr('data-open-set');

        $('div.hameleon-setting.' + attr).addClass('open');
        var timeOut = setTimeout(
            function() {
                $('div.hameleon-setting.' + attr).addClass('on');
                clearTimeout(timeOut);

            }, 200
        );

        
    }
);



$(document).on("click", ".open_more_options",
    function() {
        showHideOptions($(this), $('.more-option[data-show-options="' + $(this).attr('data-show-options') + '"]'), $(this).attr('type'));

        
    }
);

$(document).on("click", "div.edit_land span.change",
    function() {
        $(this).parent().addClass('off');
        $(this).parents('.edit_land').find('input').removeAttr('disabled').focus();

        
    }
);

$(document).on("keydown", "div.edit_land input",
    function(e) {
        if (e.which == 191)
            return false;

        
    }
);


$(document).on("keyup", "div.edit_land input",
    function(e) {

        if ($(this).val().length > 0)
            $(this).parents('div.edit_land').find('span.backslash').removeClass('off');
        else{
            $(this).parents('div.edit_land').find('span.backslash').addClass('off');
        }

        $(this).parents('div.edit_land').find('span.new_url').html($(this).val());

        
    }
);

$('div.edit_land input').focusout(function() {
    $(this).attr('disabled', 'disabled');
    $(this).parents('.edit_land').find('div.wrap-change').removeClass('off');
    
});


$(document).on('click', '.call_picker',
    function() {
        $(this).parents('div.input').find('div.picker-wrap').addClass('on');
        $(this).parents('.input').find('input.def_color').attr('style', $(this).parents('.input').find('input.picker_color').attr('style'));
        
    }
);
$(document).on('click', '.picker_panel',
    function() {
        $(this).parents('.parent-clearcolor').find('.clearcolor').addClass('on');
        
    }
);
$(document).on('click', '.picker-close',
    function() {
        $(this).parent('div.picker-wrap').removeClass('on');
        
    }
);
$(document).mouseup(
    function(e) {
        var div = $("div.picker-wrap.on");

        if (!div.is(e.target) && div.has(e.target).length === 0) {
            div.removeClass('on');
        }

        
    }
);
$(document).on("click", ".clearcolor",
    function() {
        $(this).parents('.parent-clearcolor').find('.picker_color').val(' ').removeAttr('style');
        $(this).removeClass('on');
        
    }
);

$(document).on("click", ".addrow",
    function() {
        var template_clone = $(this).parents('.parent-row').find(".empty-template").find('.row-for-copy').clone();
        var count = $(this).parents('.parent-row').find('.rows-copy').find('.row-for-copy').length;
        var count2 = count + 1;

        var name1 = $(this).parents('.parent-row').find(".empty-template").find('.for-copy-1').attr('name');
        var name2 = $(this).parents('.parent-row').find(".empty-template").find('.for-copy-2').attr('name');

        count = String(count);
        count2 = String(count2);

        name1 = name1.replace('[n' + count, '[n' + count2);
        name2 = name2.replace('[n' + count, '[n' + count2);

        $(this).parents('.parent-row').find('.rows-copy').append(template_clone);

        $(this).parents('.parent-row').find(".empty-template").find('.for-copy-1').attr('name', name1);
        $(this).parents('.parent-row').find(".empty-template").find('.for-copy-2').attr('name', name2);

        
    }
);


// 
$(document).on("click", ".on-save",
    function() {
        $(this).parents('.hameleon-setting').find('div.hameleon-set-foot').removeClass('off');
        
    }
);

$(document).on("change", ".on-save",
    function() {
        $(this).parents('.hameleon-setting').find('div.hameleon-set-foot').removeClass('off');
        
    }
);

$(document).on("focus", ".on-save",
    function() {
        $(this).parents('.hameleon-setting').find('div.hameleon-set-foot').removeClass('off');
        
    }
);
// 


$(document).on("click", "div.seo-more_info",
    function() {
        if ($(this).hasClass('on')) {
            $(this).removeClass('on');
            $(this).parents('.hameleon-set-top').find('.progress-info').slideUp(200);

        }
        else {
            $(this).addClass('on');
            $(this).parents('.hameleon-set-top').find('.progress-info').slideDown(200);
        }

        

    }
);



$(document).on("click", "div.for-copy .change",
    function() {
        $(this).parents('.wrap-change').addClass('off');
        $(this).parents('.for-copy').next().find('.seo-clone').html($(this).parents('.for-copy').find('.disabled_texarea').html()).val($(this).parents('.for-copy').find('.disabled_texarea').html());
        
    }
);
$(document).on("click", "div.seo-cancel",
    function() {
        $(this).parents('.more-option').prev().find('.wrap-change').removeClass('off');
        $(this).parent().find('.seo-clone').html('').val('');
        
    }
);

$(document).on("click", ".addrow-seo",
    function() {

        var template_clone = $(this).parents('.parent-row').find(".empty-template").children().clone();
        var count = $(this).prev().children().length;
        var count2 = count + 1;
        var name1 = $(this).parents('.parent-row').find(".empty-template").find('.seo-name').attr('name');

        count = String(count);

        name1 = name1.replace('[n' + count, '[n' + count2);


        $(this).parents('.parent-row').find('.area-for-clone').append(template_clone);

        $(this).parents('.parent-row').find(".empty-template").find('.seo-name').attr('name', name1);

        

    }
);

$(document).on('click', '.change-colls',
    function() {
        var view = 0;
        var type = $(this).attr('data-type');

        if (!($(this).parents('.big-parent-colls').find('.change-colls-info').hasClass('active')))
            $(this).parents('.big-parent-colls').find('.change-colls-info').addClass('active');

        if ($(this).parents('.parent-change-cools').hasClass('middle') && $(this).parents('div.block').hasClass('small')) {
            $(this).parents('.parent-change-cools').removeClass('col-lg-8 col-md-8 middle').addClass('col-lg-4 col-md-4 small');
            view = $(this).parents('.parent-change-cools').find('input.colls_small').val();
        }

        else if ($(this).parents('.parent-change-cools').hasClass('middle') && !($(this).parents('div.block').hasClass('small'))) {
            $(this).parents('.parent-change-cools').removeClass('col-lg-6 col-md-6 middle').addClass('col-lg-3 col-md-3 small');
            view = $(this).parents('.parent-change-cools').find('input.colls_small').val();
        }

        else if ($(this).parents('.parent-change-cools').hasClass('small') && $(this).parents('div.block').hasClass('small')) {
            $(this).parents('.parent-change-cools').removeClass('col-lg-4 col-md-4 small').addClass('col-lg-8 col-md-8 middle');
            view = $(this).parents('.parent-change-cools').find('input.colls_middle').val();
        }

        else if ($(this).parents('.parent-change-cools').hasClass('small') && !($(this).parents('div.block').hasClass('small'))) {
            $(this).parents('.parent-change-cools').removeClass('col-lg-3 col-md-3 small').addClass('col-lg-6 col-md-6 middle');
            view = $(this).parents('.parent-change-cools').find('input.colls_middle').val();
        }


        $.post("/bitrix/templates/" + tmpl + "/ajax/new_colls.php", {
            element_id: $(this).attr('data-element-id'),
            view: view,
            type: type,
            code: $(this).parents('.parent-change-cools').find('input.colls_code').val(),
            site_id: site_id,
            send: "Y"
        });

        

    }
);