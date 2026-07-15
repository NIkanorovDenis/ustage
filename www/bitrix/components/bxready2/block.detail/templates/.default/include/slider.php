<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
$loopType = $arParams["BXR_PICTURE"]["BXR_ZOOM_PICTURE_TYPE"];?>
<?$this->addExternalJs(SITE_TEMPLATE_PATH.'/js/fancybox/jquery.fancybox.js');
  $this->addExternalCss(SITE_TEMPLATE_PATH.'/js/fancybox/jquery.fancybox.css');
  $this->addExternalCss($templateFolder."/include/slider.css");
  if ($loopType !== "none")
    $this->addExternalJs('/bitrix/js/alexkova.bxready2/zoomSl/zoomsl-3.0.js');
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
function zoomOutInit() {
  $(".zoom-img").imagezoomsl({
    zoomrange: [2.12, 12],
    magnifiersize: [300, 300],
    scrollspeedanimate: 10,
    loopspeedanimate: 5,
    cursorshadeborder: "1px solid black",
    magnifiereffectanimate: "slideIn",
    magnifierborder: "1px solid #eee",
    zindex: 1000,
  });
}
function zoomInInit() {
  $(".zoom-img").imagezoomsl({
    zoomrange: [1, 12],
    zoomstart: 4,
    innerzoom: true,
    magnifierborder: "none"
  });
}
  $(window).on("resize", function(event) {
    if(window.innerWidth < 992){
      $(".bxr-element-slider-main img").removeClass("zoom-img");
    }else{
      $(".bxr-element-slider-main img").addClass("zoom-img");
      <?if ($loopType == 'inside') {?>
        zoomInInit();
      <?} elseif ($loopType == 'outside') {?>
        zoomOutInit();
      <?}?>
    }
  });
  $(function(){
    $("a.fancybox").fancybox();
    if(window.innerWidth >= 992){
      <?if ($loopType == 'inside') {?>
        zoomInInit();
      <?} elseif ($picType == "fullsize_slider" && $loopType != 'none'){?>
        zoomInInit();
      <?} elseif ($picType == "fullsize_picture" && $loopType != 'none'){?>
        zoomInInit();
      <?} elseif ($loopType == 'outside') {?>
        zoomOutInit();
      <?}?>
    };
  });
  <?if ($loopType != 'none') {?>
  $(document).on("click", ".tracker", function() {
    $('a.slick-active').trigger("click");
  });
  <?}?>
</script>
