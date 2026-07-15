<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
	$strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
}

$strReturn .= '<div class="bxr-breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList" >';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	//$nextRef = ($index < $itemSize-2 && $arResult[$index+1]["LINK"] <> ""? ' itemref="bx_breadcrumb_'.($index+1).'"' : '');
	//$child = ($index > 0? ' itemprop="child"' : '');

        $arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

		$cropLink = [
			'/catalog/raznoe/',
			'/catalog/shtativy-strubtsiny-lebedki/',
			'/catalog/fermovye-konstruktsii1/',
			'/catalog/zvukovoe-oborudovanie1/',
			'/catalog/showatelier/',
			'/catalog/spetseffekty1/',
			'/catalog/svetovoe-oborudovanie2/'
		];

		if ( in_array($arResult[$index]["LINK"], $cropLink) ) {
			$arResult[$index]["LINK"] = '#';
		}
		
		if ($arResult[$index]["LINK"] == '/product/') {
			$arResult[$index]["LINK"] = '/catalog/';
		}

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
                        <div class="bxr-breadcrumb-item bxr-font-color" itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            '.$arrow.'
                            <a class="bxr-font-color" itemprop="item" title="'.$title.'" href="'.$arResult[$index]["LINK"].'"><span itemprop="name">'.$title.'</span></a>
                            <meta itemprop="position" content="'.($index+1).'">
                        </div>';
	}
	else
	{
		$strReturn .= '
			<div class="bxr-breadcrumb-item" itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                            '.$arrow.'
                            <span >
                               <span itemprop="name">'.$title.'</span>
                               <meta itemprop="position" content="'.($index+1).'">
                            </span>
			</div>';
	}
}

$strReturn .= '<div style="clear:both"></div></div>';

return $strReturn;
