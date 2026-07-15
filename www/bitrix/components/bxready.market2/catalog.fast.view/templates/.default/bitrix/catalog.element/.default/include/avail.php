<?
if (!function_exists('printAvailHtmlV2Lite'))
{
    function printAvailHtmlV2Lite($qty, $measure, $params) {
        $params["SHOW_MAX_QUANTITY"] = 'Y';
        switch ($params["SHOW_MAX_QUANTITY"]) {
            case "M":
                if ($qty >= $params["RELATIVE_QUANTITY_FACTOR"]) {
                    $html = '<div class="bxr-instock-wrap">';
                    $html .= $params["MESS_SHOW_MAX_QUANTITY"] . ': ' . $params["MESS_RELATIVE_QUANTITY_MANY"];
                    $html .= '</div>';
                } else {
                    $html = '<div class="bxr-outstock-wrap">';
                    $html .= $params["MESS_SHOW_MAX_QUANTITY"] . ': ' . $params["MESS_RELATIVE_QUANTITY_FEW"];
                    $html .= '</div>';
                }
                break;
            case "Y": 
                $class = ($qty > 0) ? "bxr-instock-wrap" : "bxr-outstock-wrap";
                $html = '<div class="'.$class.'">';
                $html .= $params["MESS_SHOW_MAX_QUANTITY"] . ': ' . $qty . ' ' . $measure;
                $html .= '</div>';
                break;
            case "A":
                if ($qty > 0) {
                    $html = '<div class="bxr-instock-wrap">';
                    $html .= $params["QUANTITY_IN_STOCK"];
                    $html .= '</div>';
                } else {
                    $html = '<div class="bxr-outstock-wrap">';
                    $html .= $params["QUANTITY_OUT_STOCK"];
                    $html .= '</div>';                    
                }
                break;
        }

        return $html;
    }
}

$params = array(
    "SHOW_MAX_QUANTITY" => $arParams["SHOW_MAX_QUANTITY"],
    "MESS_SHOW_MAX_QUANTITY" => $arParams["MESS_SHOW_MAX_QUANTITY"],
    "RELATIVE_QUANTITY_FACTOR" => $arParams["RELATIVE_QUANTITY_FACTOR"],
    "MESS_RELATIVE_QUANTITY_MANY" => $arParams["MESS_RELATIVE_QUANTITY_MANY"],
    "MESS_RELATIVE_QUANTITY_FEW" => $arParams["MESS_RELATIVE_QUANTITY_FEW"],                                        
    "QUANTITY_IN_STOCK" => $arParams["QUANTITY_IN_STOCK"],
    "QUANTITY_OUT_STOCK" => $arParams["QUANTITY_OUT_STOCK"],                
);
?><div id="<?=$arItemIDs['AVAIL_WRAP']?>"><?
    if (count($arResult["OFFERS"]) > 0) {
        ?><div id="<?=$arItemIDs['AVAIL_WRAP'].'-'.$arResult['ID']?>" class="bxr-detail-avail-wrap"><?
    }
    echo \Alexkova\Market2\Core::printAvailHtmlV2Lite($arResult["CATALOG_QUANTITY"], $arResult["CATALOG_MEASURE_NAME"], $params);
    if (count($arResult["OFFERS"]) > 0) {?>
        </div>
        <?  foreach ($arResult["OFFERS"] as $offer) {?>
            <div class="bxr-detail-offer-avail-wrap" id="<?=$arItemIDs['AVAIL_WRAP'].'-'.$offer["ID"]?>" data-item="<?=$offer["ID"]?>" style="display: none;">
                <?echo \Alexkova\Market2\Core::printAvailHtmlV2Lite($offer["CATALOG_QUANTITY"], $offer["CATALOG_MEASURE_NAME"], $params);?>
            </div>
        <?}?>
    <?}?>
</div>

