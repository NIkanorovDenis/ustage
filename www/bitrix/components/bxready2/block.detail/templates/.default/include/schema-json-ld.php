<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$rsSites = CSite::GetByID(SITE_ID);
$arSite = $rsSites->Fetch();
$mictoFormat .= '{"@context":"http://schema.org/",'
   .'"@type":"Product",'
   .'"name":"'.$arResult["NAME"].'",'
   .'"image":"http://'. SITE_ID . $arResult["PREVIEW_PICTURE"]["SRC"].'",'
   .'"description":"'.$arResult["PREVIEW_TEXT"].'",'
   .'"mpn":"'.$arResult["PROPERTIES"]["BXR_ARTICLE"]["VALUE"].'",';
   if ($arResult["PROPERTIES"]["CML2_MANUFACTURER"]["VALUE_ENUM"]) :
	   $mictoFormat .= ',"brand":{'
	      .'"@type":"Thing",'
	      .'"name":"'.$arResult["PROPERTIES"]["CML2_MANUFACTURER"]["VALUE_ENUM"].'"'
	   ."},";
   endif;

if($arResult["PROPERTIES"]["vote_count"]["VALUE"] > 0) :
   $mictoFormat .= '"aggregateRating": {'
      .'"@type":"AggregateRating",'
      .'"ratingValue":'.$arResult["PROPERTIES"]["rating"]["VALUE"].","
      .'"reviewCount":'.$arResult["PROPERTIES"]["vote_count"]["VALUE"].","
   ."},";
endif;

if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])) :
   $mictoFormat .= '"offers": {'
      .'"@type":"Offer",'
      .'"priceCurrency":"'.($arResult["PROPERTIES"]["BXR_PRICE"]["CURRENCY"]?$arResult["PROPERTIES"]["BXR_PRICE"]["CURRENCY"]:'RUB').'",'
      .'"price":'.(($arResult["PROPERTIES"]["BXR_DISCOUNT_PRICE"]["VALUE"] > 0)?$arResult["PROPERTIES"]["BXR_DISCOUNT_PRICE"]["VALUE"]:$arResult["PROPERTIES"]["BXR_PRICE"]["VALUE"]).","
      .'"itemCondition":"http://schema.org/NewCondition",'
      .'"availability":"http://schema.org/'. ($arResult["PROPERTIES"]["BXR_INSTOCK"]["VALUE_XML_ID"]=="Y"?'InStock':'OutOfStock') . '",'
      .'"seller":{'
         .'"@type":"Organization",'
         .'"name":"'.$arSite["NAME"].'"'
."}}";
else:
   $mictoFormat .= '"offers": {';
   foreach($arResult['OFFERS'] as $key => $arOffer) :
	 $mictoFormat  .= '"@type":"Offer",'
         .'"name":"'.$arOffer["NAME"].'",'
         .'"priceCurrency":"'.($arOffer["BXR_PRICE"]["CURRENCY"]?$arOffer["BXR_PRICE"]["CURRENCY"]:'RUB').'",'
         .'"price":' . $arOffer["BXR_PRICE"]["VALUE"] . ","
         .'"itemCondition":"http://schema.org/NewCondition",'
         .'"availability":"http://schema.org/'. ($arResult["PROPERTIES"]["BXR_INSTOCK"]["VALUE_XML_ID"]=="Y"?'InStock':'OutOfStock') . '",'
	 .'"seller":{'
         	.'"@type":"Organization",'
 	        .'"name":"'.$arSite["NAME"].'"'
	."}}";
   endforeach;
endif;

$mictoFormat .= '}';
//echo "<!------------------------"; print_r($arResult) ;echo "------------------------->";
echo "<script type=\"application/ld+json\">" . $mictoFormat . "</script>";