

function formAttentionScroll(dist, parent){
    $(parent).animate({
        scrollTop: dist
    }, 700);
    
}
$(document).ready(
    function(){
        site_id = $("input.site_id").val();
        cur_pos = $(document).scrollTop();
        tmpl = $("input.tmpl").val();
        btn_type = $("input.btn_type").val();
        sect = $("input.sect").val();
        ib = $("input.ib").val();

        if($(".form-block form").is(".send"))
        {
            $("form input[name='url']").val(location.href);
            $.datetimepicker.setLocale('ru');
            $('form.form .date').datetimepicker({
                timepicker: false,
                format: 'd/m/Y',
                scrollMonth: false,
                scrollInput: false
            });
        }
        
    }
);
$(document).on("click", "form.send input[type='file']",
    function(){
        var inp = $(this);
        var btn = inp.parent();
        var lbl = btn.find("span");
        var file_api = (window.File && window.FileReader && window.FileList && window.Blob) ? true : false;
        inp.change(
            function(){
                var file_name;
                if(file_api && inp[0].files[0])
                    file_name = inp[0].files[0].name;
                else{
                    file_name = inp.val().replace("C:\\fakepath\\", '');
                }

                if(!file_name.length)
                    return;

                if(lbl.is(":visible")){
                    lbl.text(file_name);
                    lbl.removeClass("area-file");
                    lbl.closest('.load-file').removeClass("has-error");

                }
                else{
                    btn.text(file_name);
                }
            }
        ).change();
        
    }
);
$(document).on("click", "form.form input[type='checkbox']",
    function(){
        $(this).parents("div.wrap-agree").removeClass("has-error");
        
    }
);
/*send form*/
$(document).on("submit", "form.send",
    function(){
        var form = $(this);
        var path = "/bitrix/templates/concept_hameleon/ajax/forms.php";

        if(form.hasClass('form-box'))
            path = "/bitrix/components/concept/hameleon_cart/order.php";

        form.css({
            "height": form.outerHeight() + "px"
        });

        var formData = new FormData(form.get(0));
        formData.append("send", "Y");
        var button = $("button[name='form-submit']", form);
        var link = button.attr("data-link");
        var header = $("input[name='header']", form);
        var agreecheck = $("input[name='checkboxAgree']", form);
        var questions = $("div.questions", form);
        var load = $("div.load", form);
        var thank = $("div.thank", form);
        var error = 0;

        if(typeof(agreecheck.val()) != "undefined"){
            if(!agreecheck.prop("checked")){
                agreecheck.parents("div.wrap-agree").addClass("has-error");
                error = 1;
            }
        }
        $("input[type='text'], input[type='password'], textarea", form).each(
            function(key, value){

                if($(this).hasClass("email") && $(this).val().length > 0){
                    if(!(/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test($(this).val())){
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                    }
                }
                if($(this).hasClass("require")){
                    if($(this).val().length <= 0){
                        $(this).parent("div.input").addClass("has-error");
                        error = 1;
                    }
                }
            }
        );
        $("input[type='file']", form).each(
            function(key, value){
                if($(this).hasClass("require")){
                    if($(this).closest('.load-file').find('span.area-file').hasClass('area-file')){
                        $(this).closest('.load-file').addClass("has-error");
                        error = 1;
                    }
                }
            }
        );
        if(!$('.ham-modal').hasClass('form-modal')){
            var otherHeight = 0;
            if($('header').hasClass('slide'))
                otherHeight = $('header .header-block').outerHeight(true);
        }
        if(error == 1){
            if($('.ham-modal').hasClass('form-modal'))
                formAttentionScroll(form.find('.has-error:first').offset().top - form.parents('.ham-modal-dialog').offset().top, ".ham-modal");

            else if(form.hasClass('form-box'))
                formAttentionScroll(form.find('.has-error:first').offset().top - form.find(".body").offset().top, ".box-parent");

            else{
                formAttentionScroll(form.find('.has-error:first').offset().top - otherHeight, "html:not(:animated),body:not(:animated)");
            }
        }

        if(error == 0){
            formData.delete("important_id");
            button.removeClass("active");
            load.addClass("active");
            var timeOut = setTimeout(
                function(){
                    $.ajax({
                        url: path,
                        type: "post",
                        contentType: false,
                        processData: false,
                        data: formData,
                        dataType: 'json',
                        success: function(json){

                            /*$("body").append(json);*/

                            if(json.OK == "N"){
                                button.addClass("active");
                                load.removeClass("active");
                            }
                            if(json.OK == "Y"){
                                questions.removeClass("active");
                                thank.addClass("active");

                                setTimeout(
                                    function(){

                                        if($('.ham-modal').hasClass('form-modal'))
                                            formAttentionScroll(form.find('.thank').offset().top - form.parents('.ham-modal-dialog').offset().top, ".ham-modal");

                                        else if(form.hasClass('form-box'))
                                            formAttentionScroll(form.find('.thank').offset().top - form.find(".body").offset().top, ".box-parent");

                                        else{
                                            formAttentionScroll(form.find('.thank').offset().top - otherHeight, "html:not(:animated),body:not(:animated)");
                                        }

                                    }, 300);
                                if(form.hasClass('form-box'))
                                {
                                    setTimeout(
                                        function(){
                                            updateBox("","","","clear","");
                                            form.find(".areabox-form").children().remove();
                                            form.find(".box-back").removeClass('active');
                                            form.find(".areabox-form").removeClass('active');
                                            form.find(".info-table").addClass('active');

                                        }, 3000);
                                }
                                if(typeof(link) != "undefined"){

                                    setTimeout(
                                        function(){

                                            location.href = link;


                                        }, 3000);
                                }

                                if(json.YANDEX.length > 0){
                                    $('body').append(json.YANDEX);
                                }
                                if(json.GOOGLE.length > 0){
                                    $('body').append(json.GOOGLE);
                                }
                                if(json.GTM.length > 0){
                                    $('body').append(json.GTM);
                                }

                                $.ajax({
                                    url: "/",
                                    type: "post",
                                    success: function(json){}

                                });

                            }                          
                        }
                    });
                    clearTimeout(timeOut);
                }, 1000);
        }
        return false;
    }
);
$(document).on("click", "a.form-close",
    function(){
        $("div.click-for-reset.on").removeClass("on");
        $('div.wrapper').removeClass('blur');
        $('body').removeClass("modal-open");
        $('.wrap-modal.open').removeClass('blur');

        if(device.ios()){
            $("body").removeClass("modal-ios");
            window.scrollTo(0, cur_pos);
        }

        

    }
);

$(document).on('click', '.call-modal',
    function(){
        if(!$("body").hasClass("modal-ios"))
            cur_pos = $(document).scrollTop();

            var path = '';
            var area = '';
            var value = $(this).attr("data-call-modal");
            var header = $(this).attr("data-header");
            var from = $(this).attr("data-from-open-modal");
            var element_id = "";
            var element_type = "";
            var other_complect = "";

            if($(this).hasClass("more-modal-info")){
                element_id = $(this).attr("data-element-id");
                element_type = $(this).attr("data-element-type");

                if($(this).hasClass('from-modal'))
                    other_complect = $(this).parents(".tabs-content").find("input[name='other_complect']:checked").val();
            }

            var type = "";
            var box_form = "";

            var th = $(this);

            $('div.wrapper').addClass('blur');

            if($(this).hasClass('box-form'))
            {
                area = 'areabox-form';
                path = 'form_box.php';
                value = value.replace("form", "");

                if($(this).hasClass('main-click'))
                    box_form = "Y";
            }

            if($(this).hasClass('callform')){
                area = 'modalAreaForm';
                path = 'formmodal.php';
                value = value.replace("form", "");
            }


            if($(this).hasClass('callvideo')){
                area = 'modalAreaVideo';
                path = 'videomodal.php';
            }

            if($(this).hasClass('callmodal')){
                area = 'modalAreaWindow';
                path = 'windowmodal.php';
                value = value.replace("modal", "");
            }

            if($(this).hasClass('callagreement')){
                area = 'modalAreaAgreement';
                path = 'agreemodal.php';
                value = value.replace("agreement", "");
            }


            $('.google-spin-wrapper').addClass('active');

            $.post("/bitrix/templates/" + tmpl + "/ajax/" + path,{
                    resVal: value,
                    site_id: site_id,
                    type: type,
                    btn_type: btn_type,
                    section: sect,
                    ib: ib,
                    element_id: element_id,
                    element_type: element_type,
                    other_complect: other_complect,
                    box_form: box_form

                },

                function(html){

                    $("body").addClass("modal-open");

                    if(device.ios() && !th.hasClass('box-form')){
                        $("body").addClass("modal-ios");
                    }

                    $('div.' + area).html(html);
                    $('.google-spin-wrapper').removeClass('active');

                    if(from == 'open-menu'){
                        $('div.open-menu').addClass('blur');
                        $('div.' + area).find('.close-modal').addClass('open-menu');
                    }

                    var timeOut = setTimeout(
                        function(){
                            $('div.' + area).find('.ham-modal').addClass('active');
                            clearTimeout(timeOut);
                        }, 300);


                    if(area == 'modalAreaForm'){
                        var timeOut2 = setTimeout(
                            function(){

                                $('div.modalAreaForm').find("form input[name='url']").val(decodeURIComponent(location.href));

                                if(typeof(comment) != "undefined"){
                                    if(comment.length > 0)
                                        $("div.modalAreaForm").find("div.add_text").html(comment);

                                }

                                if(typeof(formTitle) != "undefined"){
                                    if(formTitle.length > 0)
                                        $('div.modalAreaForm').find("form input[name='comment']").val(formTitle);
                                }

                                if(typeof(header) != "undefined"){
                                    if(header.length > 0)
                                        $('div.modalAreaForm').find("form input[name='header']").val(header);
                                }

                                $('div.modalAreaForm form.form .date').datetimepicker({
                                    timepicker: false,
                                    format: 'd/m/Y',
                                    scrollMonth: false,
                                    scrollInput: false
                                });
                                clearTimeout(timeOut2);
                            }, 100
                        );
                    }

                    if(area == 'modalAreaVideo'){
                        var timeOut2 = setTimeout(
                            function(){
                                var win_height = $('div.video-modal').height();
                                var modal = 590;
                                if($(window).width() > 767){
                                    if(win_height > modal)
                                        $("div.video-modal div.ham-modal-dialog").addClass('pos-absolute');
                                    else{
                                        $("div.video-modal div.ham-modal-dialog").removeClass('pos-absolute');
                                    }
                                }
                                else{
                                    $("div.video-modal div.ham-modal-dialog").addClass('pos-absolute');
                                }

                                clearTimeout(timeOut2);
                            }, 100
                        );
                    }


                    if(th.hasClass('from-modalform')){
                        $('div.modalAreaAgreement').find('.close-modal').addClass('from-modal');
                        $('div.modalAreaAgreement').find('.close-modal').addClass('from-modalform');
                        $('div.form-modal').addClass('blur');
                    }

                    if(th.hasClass('from-openmenu')){
                        $('div.modalAreaForm').find('.close-modal').addClass('from-modal');
                        $('div.modalAreaAgreement').find('.close-modal').addClass('from-modal');
                        $('div.modalAreaAgreement').find('.close-modal').addClass('from-openmenu');
                        $('div.modalAreaForm').find('.close-modal').addClass('from-openmenu');
                        $('div.open-menu').addClass('blur');
                        $('div.modalAreaWindow').find('.close-modal').addClass('from-modal');
                        $('div.modalAreaWindow').find('.close-modal').addClass('from-openmenu');
                    }

                    if(th.hasClass('from-set')){
                        $('div.modalAreaForm').find('.close-modal').addClass('from-modal');
                        $('div.modalAreaWindow').find('.close-modal').addClass('from-modal');
                    }

                    if(th.hasClass('from-tariff')){
                        $('div.wrap-modal').addClass('blur');
                        $('div.modalAreaAgreement').find('.close-modal').addClass('from-tariff');
                        $('div.modalAreaForm').find('.close-modal').addClass('from-tariff');
                        $('div.modalAreaWindow').find('.close-modal').addClass('from-tariff');
                    }

                    if(area == 'areabox-form')
                    {                    
                        th.parents(".wrapper-mbox").find(".info-table").removeClass('active');
                        th.parents(".wrapper-mbox").find(".box-back").addClass('active');
                        th.parents(".wrapper-mbox").find(".areabox-form").addClass('active');
                        th.parents(".wrapper-mbox").find("form input[name='url']").val(decodeURIComponent(location.href));
                        $('.wrapper-mbox form.form .date').datetimepicker({
                            timepicker: false,
                            format: 'd/m/Y',
                            scrollMonth: false,
                            scrollInput: false
                        });
                    }

                }
            );
        
        

    }
);
$(document).on('click', '.close-modal',
    function(){
        $('div.modalAreaForm form.form .date').datetimepicker('destroy');
        if(!($(this).hasClass('from-modal')) && !($(this).hasClass('from-tariff'))){
            $('div.wrapper').removeClass('blur');
            $("body").removeClass("modal-open");

            if(device.ios()){
                $("body").removeClass("modal-ios");
                window.scrollTo(0, cur_pos);
            }
        }
        if($(this).hasClass('from-modalform'))
            $('div.form-modal').removeClass('blur');

        if($(this).hasClass('from-openmenu'))
            $('div.open-menu').removeClass('blur');

        if($(this).hasClass('from-tariff'))
            $('div.wrap-modal').removeClass('blur');

        if($(this).hasClass('wind-close'))
            $(this).parents("div.shadow-modal-wind-contact").removeClass('on');

        else{
            $(this).parents("div.modalArea").children().remove();
        }

        
    }
);
$(document).on("click", ".box-back",
    function(e){
        $(this).removeClass('active');
        $(this).parents(".wrapper-mbox").find(".areabox-form").removeClass('active');
        $(this).parents(".wrapper-mbox").find(".info-table").addClass('active');

        
    }
);
$(document).on('click', '.open_modal_contacts',
    function(){
        $('div.shadow-modal-wind-contact').addClass('on');
        $('div.wrapper').addClass('blur');
        $("body").addClass("modal-open");

        if(device.ios()){
            cur_pos = $(document).scrollTop();
            $("body").addClass("modal-ios");
        }

        
    }
);
$(document).on("click", ".btn-modal-open",
    function(){
        var id = $(this).attr('data-element-id');
        var name = $(this).attr('data-detail');
        var btnColor = $(this).attr('data-btn-color');
        var site_id = $(this).attr('data-site-id');
        var all_id = $(this).attr('data-all-id');
        var catalog_id = $(this).attr('data-main-catalog-id');
        cur_pos = $(document).scrollTop();

        var added = "N";
        if($(this).parents(".element").find(".click_box").hasClass('added'))
            added = "Y";

        var section_id = $(this).attr('data-section-id');
        var block_header = $(this).attr('data-header');

        $('div.google-spin-wrapper').addClass('active');

        $.post("/bitrix/templates/" + tmpl + "/ajax/modal.php",{
            element_id: id,
            name: name,
            all_id: all_id,
            site_id: site_id,
            section_id: section_id,
            block_header: block_header,
            btnColor: btnColor,
            site_id: site_id,
            added: added,
            catalog_id: catalog_id

            },

            function(html){
                
                $('div.wrap-modal').addClass('open');
                $('div.wrapper').addClass('blur');
                $('body').addClass('modal-open');
                $('.shadow-detail').addClass('active');
                $("div.modal-container").html(html);

                var win_height = $('.wrap-modal-outer').height();

                var count = 0;
                var completed = 0;

                $('.wrap-modal-outer').find(".bot-wrap").find('img').each(function(){
                    count++;
                });


                if(count>0)
                {
                    $('.wrap-modal-outer').find(".bot-wrap").find('img').each(function(){
                        $(this).load(function(){
                            completed++;

                            if(completed == count)
                            {
                                var timeOut = setTimeout(
                                function(){

                                    modal_height = $('.wrap-modal-inner').outerHeight();

                                    if(win_height > modal_height)
                                        $(".wrap-modal-inner").addClass('pos-absolute');

                                    else{
                                        $(".wrap-modal-inner").removeClass('pos-absolute');
                                    }
                                    $(".wrap-modal-inner").addClass('open');
                                    $('div.no-click-block').addClass('on');

                                    $('div.google-spin-wrapper').removeClass('active');

                                    clearTimeout(timeOut);

                                }, 100);

                            }
                        });

                        
                    });  

                }

                else
                {
                    var timeOut = setTimeout(
                        function(){

                            modal_height = $('.wrap-modal-inner').outerHeight();

                            if(win_height > modal_height)
                                $(".wrap-modal-inner").addClass('pos-absolute');

                            else{
                                $(".wrap-modal-inner").removeClass('pos-absolute');
                            }
                            $(".wrap-modal-inner").addClass('open');
                            $('div.no-click-block').addClass('on');

                            $('div.google-spin-wrapper').removeClass('active');

                            clearTimeout(timeOut);

                        }, 100);

                }
                



                $(".area_for_mini_box").addClass('mod_cat_opened');
            }
        );

        
    }
);
/*for close detail-modal*/
$(document).on("click", "a.wrap-modal-close",
    function(){
        $('div.wrap-modal').removeClass('open');
        $('.shadow-detail').removeClass('active');
        $('body').removeClass('modal-open');
        $('div.wrapper').removeClass('blur');
        $('div.no-click-block').removeClass('on');

        if($(".area_for_mini_box").hasClass("mod_cat_opened"))
            $(".area_for_mini_box").removeClass('mod_cat_opened');

        if(device.ios()){
            window.scrollTo(0, cur_pos);
            $("body").removeClass("modal-ios");
        }

        
    }
);
/*hide and show placeholder*/
$(document).on("focus", "form input[type='text'], form textarea",
    function(){
        $(this).parent("div.input").removeClass("has-error");
        
    }
);
$(document).on("blur", "form input[type='text'], form textarea",
    function(){
        $(this).parent("div.input").removeClass("has-error");
        
    }
);
$(document).on('click', '.select-list-choose',
    function(){
        $(this).parents('.form-select').addClass('open');
        
    }
);
$(document).on('click', '.ar-down',
    function(){
        if($(this).parents('.form-select').hasClass('open'))
            $(this).parents('.form-select').removeClass('open');
        else{
            $(this).parents('.form-select').addClass('open');
        }
        
    }
);
$(document).on('click', '.form-select .name',
    function(){
        $(this).parents('.form-select').find('.select-list-choose').removeClass('first').find(".list-area").text($(this).text());
        $(this).parents('.form-select').removeClass('open');
        
    }
);

$(document).mouseup(function (e){
    var div = $(".form-select");
    if (!div.is(e.target)
        && div.has(e.target).length === 0) {
        div.removeClass('open');
    }
    
});



$(document).on('change', ".box-choose-select",
    function(){
        $(this).parents(".parent-choose-select").find(".inp-show-js").removeClass('active');
        $(this).parents(".parent-choose-select").find(".inp-show-js[data-choose-select='"+$(this).attr("data-choose-select")+"']").addClass('active');
        
});
$(document).on("focus", "input.focus-anim",
    function(){
        if($(this).val() == "")
            $(this).parent().addClass('in-focus');

        
    }
);
$(document).on("blur", "input.focus-anim",
    function(){
        if($(this).val() == "")
            $(this).parent().removeClass('in-focus');

        
    }
);
/**/
$(document).on("keypress", ".only-num",
    function(e){
        e = e || event;
        if(e.ctrlKey || e.altKey || e.metaKey) return;
        var chr = getChar(e);
        if(chr == null) return;
        if(chr < '0' || chr > '9'){
            return false;
        }
    }
);
/*focus input*/
$(document).on("focus", "input.focus-anim, textarea.focus-anim",
    function(){
        if($(this).val() == "")
            $(this).parent().addClass('in-focus');

        
    }
);
$(document).on("blur", "input.focus-anim, textarea.focus-anim",
    function(){
        element = $(this);
        var timeOut = setTimeout(
            function(){
                if(element.val() == "")
                    element.parent().removeClass('in-focus');

                clearTimeout(timeOut);
            }, 200
        );

        
    }
);