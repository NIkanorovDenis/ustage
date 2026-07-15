<?$this->addExternalCss($templateFolder."/include/slider.css");
  if ($loopType !== "none")
        $this->addExternalJs('/bitrix/js/alexkova.bxready2/jquery.loupe.min.js');

$picType = $arParams["BXR_PICTURE"]["BXR_DETAIL_PICTURE_TYPE"];?>
<div class="container-fluid">
    <div class="row">
        <?if (($picType == "slider" || $picType == "fullsize_slider") && (count($arResult["IMAGES"]) > 0) ):?>
            <div class="bxr-element-slider">
                <?include ('picture/slider.php');?>
            </div>
        <?elseif(!empty($arResult["DETAIL_PICTURE"])):?>
            <div class="bxr-element-slider">
                <?include ('picture/picture.php');?>
            </div>
        <?endif;?>
    </div>
</div>
<script type="text/javascript">
    function fancyReinit() {
        $("[data-fancybox]").fancybox({
            slideShow: false,
            fullScreen: false,
            onComplete: function() {
                $('.fancybox-thumbs').scrollbar();
                $('.scroll-bar').addClass('bxr-color');
            },
            thumbs : {
                showOnStart: true,
            },
        });
    };

    function zoomReInit() {
        $('.bxr-zoom-img').loupe({loupe:'bxr-loupe'});
    };

    $(function(){
        fancyReinit();
    });

    <?if ($loopType != 'none') {?>
        $(document).on("click", ".bxr-loupe", function() {
            var src = $(this).find("img").attr("src");
            $('.bxr-zoom-img[src="' + src + '"]').closest('a.slick-active').trigger("click");
        });
    <?}?>
</script>