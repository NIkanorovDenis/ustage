<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
if (is_array($arResult["SCHEMES"]) && count($arResult['SCHEMES'])>0) {
    $elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
    $elementDraw->setCurrentTemplate($this);
?>
    <div class="row">
        <?foreach ($arResult["SCHEMES"] as $val){
            $arRes = array(
                "SIZE_LIMIT" => array(
                    'width' => 300,
                    'height' => 150
                ),
                'DETAIL_PAGE_URL' => $val['SRC'],
                'PREVIEW_PICTURE'=>$val,
                'NAME'=>$val['DESCRIPTION'],
            );

            $arParam = array(
                'ADD_CLASS'=>'bxr-fancy',
                'ADD_REL'=>'shemes_gallery'
            );
        ?>
        <div class="col-xs-12 col-md-4">
            <?$elementDraw->showElement('elements', 'image.v1', $arRes, $arParam);?>
        </div>
        <?}?>
    </div>

    <script>
        $(".bxr-fancy").fancybox({
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
    </script>
<?}?>