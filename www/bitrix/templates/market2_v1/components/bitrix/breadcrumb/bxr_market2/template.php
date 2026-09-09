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

// Bitrix uses the inherited SECTION_PAGE_TITLE in the navigation chain. If a
// child section does not define its own value, it receives the parent's title
// and breadcrumbs become duplicated or misleading. For catalog sections use
// the section's actual name; SEO page titles and meta tags remain untouched.
$catalogSectionCodes = array();
foreach ($arResult as $chainItem)
{
	$linkPath = parse_url($chainItem['LINK'], PHP_URL_PATH);
	if (is_string($linkPath) && preg_match('#^/catalog/([^/]+)/?$#', $linkPath, $matches))
	{
		$catalogSectionCodes[] = rawurldecode($matches[1]);
	}
}

$catalogSectionNames = array();
if (!empty($catalogSectionCodes) && CModule::IncludeModule('iblock'))
{
	$sections = CIBlockSection::GetList(
		array(),
		array(
			'IBLOCK_ID' => 32,
			'=CODE' => array_values(array_unique($catalogSectionCodes)),
		),
		false,
		array('ID', 'NAME', 'CODE')
	);

	while ($section = $sections->Fetch())
	{
		$catalogSectionNames[$section['CODE']] = $section['NAME'];
	}
}

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
	$itemTitle = $arResult[$index]["TITLE"];
	$linkPath = parse_url($arResult[$index]['LINK'], PHP_URL_PATH);
	if (is_string($linkPath) && preg_match('#^/catalog/([^/]+)/?$#', $linkPath, $matches))
	{
		$sectionCode = rawurldecode($matches[1]);
		if (isset($catalogSectionNames[$sectionCode]))
		{
			$itemTitle = $catalogSectionNames[$sectionCode];
		}
	}

	$title = htmlspecialcharsex($itemTitle);

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
