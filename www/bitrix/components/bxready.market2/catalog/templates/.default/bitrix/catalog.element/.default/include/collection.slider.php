<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$useBrands = ('Y' == $arParams['BRAND_USE']);

if (isset($arParams["BXREADY_DETAIL_MARKER_TYPE"]) && strlen($arParams["BXREADY_DETAIL_MARKER_TYPE"])>0)
	$markerCollection = $arParams["BXREADY_DETAIL_MARKER_TYPE"];
if (isset($arParams["BXREADY_DETAIL_OWN_MARKER_USE"]) && $arParams["BXREADY_DETAIL_OWN_MARKER_USE"] == "Y"
	&& isset($arParams["BXREADY_DETAIL_OWN_MARKER_TYPE"]) && strlen($arParams["BXREADY_DETAIL_OWN_MARKER_TYPE"])>0)
	$markerCollection = $arParams["BXREADY_DETAIL_OWN_MARKER_TYPE"];
if (strlen($markerCollection) > 0)
	$elementDraw->setMarkerCollection($markerCollection);

$markerGroup = array();
if ($arResult["PROPERTIES"]["RECOMMENDED"]["VALUE_XML_ID"] == "Y")
	$markerGroup["REC"] = true;
if ($arResult["PROPERTIES"]["NEWPRODUCT"]["VALUE_XML_ID"] == "Y")
	$markerGroup["NEW"] = true;
if ($arResult["PROPERTIES"]["SALELEADER"]["VALUE_XML_ID"] == "Y")
	$markerGroup["HIT"] = true;
if ($arResult["PROPERTIES"]["SPECIALOFFER"]["VALUE_XML_ID"] == "Y")
	$markerGroup["SALE"] = true;

$markerParams = array(
	"BXREADY_USER_TYPES" => $arParams["BXREADY_DETAIL_OWN_MARKER_USE"],
	"BXREADY_USER_TYPE_VARIANT" => $markerCollection
);
?>
	<div id="<?=$arItemIDs["SLIDER_WRAP_ID"]?>" class="bxr-element-slider">
		<?$elementDraw->showMarkerGroup($markerGroup, false, $markerParams);?>
		<div id="<?=$arItemIDs["SLIDER_CONT_ID"]?>" class="bxr-element-slider-main">
			<?if (count($arResult["MORE_PHOTO"]) > 0) :
				foreach ($arResult["MORE_PHOTO"] as $key => $val) :
					$dataAtr = "";
					foreach ($val["GROUP"] as $keyval => $value) {
						if ($value)
							$dataAtr .= "data-".strtolower($keyval)."='".$value."' ";
					}
					?>
					<a class="<?=(substr_count($arParams["DETAIL_PICTURE_MODE"], "ZOOM") > 0)?"bxr-zoom-img-cont":"";?>" <?=($key == 0) ? 'id="'.$arItemIDs['MAIN_PHOTO_ID'].'"' : ''?>
					   <?if (substr_count($arParams["DETAIL_PICTURE_MODE"], "POPUP")) {?>href="<?=$val["SRC"]?>" data-rel="gallery" data-fancybox="bx-gallery"<?}?>
					   data-item="<?=$val["ITEM_ID"]?>" <?=$dataAtr?>>
						<img id="<?=$arItemIDs['ZOOM']?>" src="<?=$val["SRC"]?>" class="bxr-zoom-img" title="<?=$strTitle?>" alt="<?=$strAlt?>" itemprop="image">
					</a>
				<?endforeach;
				if ($useBrands && $arResult["PROPERTIES"][$arParams["BRAND_PROP_CODE"][0]]["VALUE"]) :
					echo '<div class="brand-detail">';
					$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", "element_detail", array(
						"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
						"IBLOCK_ID" => $arParams['IBLOCK_ID'],
						"ELEMENT_ID" => $arResult['ID'],
						"ELEMENT_CODE" => "",
						"PROP_CODE" => $arParams['BRAND_PROP_CODE'],
						"CACHE_TYPE" => $arParams['CACHE_TYPE'],
						"CACHE_TIME" => $arParams['CACHE_TIME'],
						"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
						"WIDTH" => "176",
						"HEIGHT" => "76",
						"WIDTH_SMALL" => "176",
						"HEIGHT_SMALL" => "76",
					),
						$component,
						array("HIDE_ICONS" => "Y")
					);
					echo '</div>';
				endif;
			else: ?>
				<div id="<?=$arItemIDs['MAIN_PHOTO_ID']?>" class="bxr-no-image-detail-wrap">
					<img src="<?=$elementDraw->getDefaultImage()?>" alt="No photo">
				</div>
			<?endif;?>
		</div>
		<div id="<?=$arItemIDs["SLIDER_NAV_CONT_ID"]?>" class="bxr-element-slider-nav nav-hor hidden-xs">
			<?foreach ($arResult["MORE_PHOTO"] as $key => $val):
				$file = CFile::ResizeImageGet($val['ID'], array('width'=>115, 'height'=>115), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				$dataAtr = "";
				foreach ($val["GROUP"] as $keyval => $value) {
					if ($value)
						$dataAtr .= "data-".strtolower($keyval)."='".$value."' ";
				}
				?>
				<div class="slick-nav" data-item="<?=$val["ITEM_ID"]?>" <?=$dataAtr?>>
					<div<?=($key == 0) ? ' id="'.$arItemIDs['MAIN_PHOTO_SMALL_ID'].'"' : ''?> class="slide-wrap<?=($key == 0) ? ' first-slide' : ''?>" data-item="<?=$val["ITEM_ID"]?>">
						<img src="<?=($file["src"])?: $val["SRC"]?>" title="<?=$strTitle?>" alt="<?=$strAlt?>" itemprop="image">
					</div>
				</div>
			<?endforeach;?>
		</div>
	</div>
<?if (count($arResult["MORE_PHOTO"]) > 0):?>
	<script>
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

        $('#'+'<?=$arItemIDs["SLIDER_CONT_ID"]?>').on('afterChange', function(event, slick, currentSlide, nextSlide){
            data = $('<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>').find('.slick-active').data('slick-index');
            $($('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-track').children('.slick-slide')).removeClass("bxr-border-color").addClass("bxr-def-border");
            $($('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-track').children('.slick-slide[data-slick-index='+data+']')).removeClass("bxr-def-border").addClass("bxr-border-color");
        });

        var <?='ob'.$arItemIDs["SLIDER_CONT_ID"]?> = $('<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 300,
            arrows: true,
            prevArrow: '<button type="button" class="bxr-color-button slick-prev"></button>',
            nextArrow: '<button type="button" class="bxr-color-button slick-next"></button>',
            fade: true,
            dots: false,
            infinite: true,
            cssEase: 'linear',
            asNavFor: '<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>',
            slide: 'a'
        });

        $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>').on('afterChange', function(event, slick, currentSlide, nextSlide){
            $($('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-nav')).removeClass("bxr-border-color").addClass("bxr-def-border");
            $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-nav.slick-current').removeClass("bxr-def-border").addClass("bxr-border-color");
        });

        var <?='ob'.$arItemIDs["SLIDER_NAV_CONT_ID"]?> = $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            speed: 300,
            arrows: true,
            prevArrow: '<button type="button" class="bxr-color-button-vertical slick-prev"><i class="fa fa-angle-up"></i></button>',
            nextArrow: '<button type="button" class="bxr-color-button-vertical slick-next"><i class="fa fa-angle-down"></i></button>',
            dots: false,
            infinite: true,
            centerMode: false,
            cssEase: 'linear',
            asNavFor: '<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>',
            focusOnSelect: true,
            slide: 'div',
            vertical: true,
        });


        $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-slide').on('click', function(e){
            sCnt = $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-nav:not(.slick-cloned)').length - 1;
            c = $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-nav:not(.slick-cloned)[data-item='+$(this).data('item')+'][data-slick-index='+$(this).data('slick-index')+']').index();
            clone = $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-nav.slick-cloned').length / 2;
            index = (c>0) ? c - clone : 0;
            gSlide = (index > sCnt) ? sCnt : index;

            $($('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-nav')).removeClass("bxr-border-color").addClass("bxr-def-border");
            $(this).removeClass("bxr-def-border").addClass("bxr-border-color");

            setTimeout(function() {$('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>').slick('slickGoTo', gSlide)}, 300);
            setTimeout(function() {$('<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>').slick('slickGoTo', gSlide)}, 300);
        });

        $(document).ready(function() {
            $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>').children(".slick-prev").css("display", "none");
            $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>').children(".slick-next").css("display", "none");
            $('<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>').children(".slick-prev").css("display", "none");
            $('<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>').children(".slick-next").css("display", "none");
            $('<?='#'.$arItemIDs["SLIDER_WRAP_ID"]?>').show();
            $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>').slick('slickFilter','[data-main="default"]');
            $('<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>').slick('slickFilter','[data-main="default"]');
            $($('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-nav:not(.slick-cloned)')[0]).addClass("bxr-border-color");
            $($('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-nav:not(.slick-cloned)')[0]).trigger('click');
            fancyReinit();
        });

        $(window).on("load", function() {
            setSlideSizes();
        });

        $(document).on("mouseover", '<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>', function() {
            hideArrows(this, "block");
        });

        $(document).on("mouseover", '<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>', function() {
            hideArrows(this, "block");
        });

        $(document).on("mouseout", '<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>', function() {
            hideArrows(this, "none");
        });

        $(document).on("mouseout", '<?='#'.$arItemIDs["SLIDER_CONT_ID"]?>', function() {
            hideArrows(this, "none");
        });

        $(window).resize(function() {
            setSlideSizes();
        });

        function hideArrows(elem, display) {
            $(elem).children(".slick-prev").css("display", display);
            $(elem).children(".slick-next").css("display", display);
        }

        function setSlideSizes() {
            border = 4;
            width = $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-list .slick-track .slick-slide').width();
            height = width + border;
            imgSize = width - 10;
            $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-track .slick-slide').height(height);
            $('<?='#'.$arItemIDs["SLIDER_NAV_CONT_ID"]?>'+' .slick-track .slick-slide .slide-wrap').css({'width': height, 'height': height, 'line-height': height+'px'})
        }

		<?if (substr_count($arParams["DETAIL_PICTURE_MODE"], "ZOOM") > 0) {?>
        zoomReInit();
        //            $(function () { $("a.easyzoom").easyZoom(); });
        //            $(window).on("load", function() {
        //                var zoom;
        //                zoomReInit();
        $(document).on("click", ".bxr-loupe", function() {
            var src = $(this).find("img").attr("src");
            $('.bxr-zoom-img[src="' + src + '"]').closest('a.slick-active').trigger("click");
        });
        //            });
		<?}?>
	</script>
<?endif;