<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="total<?if($arResult["SALE"]):?> sale_on<?endif;?>">
    
    <div class="desc-top">
        <?=$arResult["SALE_TEXT"]?>
    </div>
    <div class="total-price bold parent-preload-circleG total-parent-preload-circleG">
    	<div class="circleG-opacity">
            <?
    	    	if($arResult["REQUEST_PRICE"])
    	    		echo $arResult["REQUEST_PRICE_REQ"];

    	    	else
    	    		echo $arResult["TOTAL_NEW"];
        	?>
        </div>

        <div class="circleG-wrap">
            <div class="circleG circleG_1"></div>
            <div class="circleG circleG_2"></div>
            <div class="circleG circleG_3"></div>
        </div>
     
    </div>

</div>

<?if($arResult["SALE"]):?>

    <div class="updesc"><?=GetMessage('HAM_BOX_ECONOM');?> 

        <span class="total bold parent-preload-circleG total-parent-preload-circleG">

            <span class="circleG-opacity"><?=$arResult["TOTAL_SALE"]?></span>

            <div class="circleG-wrap small">
                <div class="circleG circleG_1"></div>
                <div class="circleG circleG_2"></div>
                <div class="circleG circleG_3"></div>
            </div>
            
        </span>

    </div>

<?endif;?>
                                           

                                            