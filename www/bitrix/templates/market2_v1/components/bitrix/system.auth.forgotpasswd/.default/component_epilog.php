<script>
    $(document).ready(function(){
        $(document).on("click", "#bxr-form-forgotpasswd .reloadCaptcha", function(){
            var $that = $(this).parents(".captchaBlock");
            var captchaImg = $that.find(".captchaImg").css({"opacity": "0.3"});

            $.getJSON('<?=$templateFolder?>/reload_captcha.php', function(data) {
               captchaImg.attr('src','/bitrix/tools/captcha.php?captcha_sid='+data).css({"opacity": "1"});;
               $that.find(".captchaSid").val(data);
            });
           return false;
        });
        
     });
</script>