<?php
//$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../../../..');
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);*/

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

//@set_time_limit(0);
//@ignore_user_abort(true);

ini_set('max_execution_time', '3600'); //1 час
ini_set('memory_limit', '2048M');

/*
1.  Товары со второй вкладки прайса поставщика «Окно Аудио» («Ограничено к ввозу») необходимо откорректировать:
a.  Товары дешевле 28 000,00 – не показывать наличие и цену (статусы «Уточнить наличие», «Уточнить цену»).

b.  Товары от 28 000,00 к загружаемой из прайса поставщика розничной цене должно прибавляться +10%. 
*/


$res = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>32, 'ACTIVE'=> 'Y', '!PROPERTY_PRICE_LIMIT' => false), false, false, array());
$i = 1;
$count = $res->SelectedRowsCount();
while($row = $res->GetNextElement()){
    
    $i++;

    if ($i > 15000) exit;

    $arFields = $row->GetFields();
    $ID = $arFields['ID'];

    $arProps = $row->GetProperties();

    $CML2_ARTICLE = $arProps['CML2_ARTICLE']['VALUE'];
    $PRICE_LIMIT = $arProps['PRICE_LIMIT']['VALUE'];

    if (!empty($PRICE_LIMIT)) {
        $PRICE_LIMIT = preg_replace("/[^,.0-9]/", '', $PRICE_LIMIT);
        $PRICE_LIMIT = trim($PRICE_LIMIT, '.');
        $PRICE_LIMIT = str_replace(" ", "", $PRICE_LIMIT);
        $PRICE_LIMIT = str_replace(",", ".", $PRICE_LIMIT);

        if ($PRICE_LIMIT > 0) {

            //Розничная цена
            $BASE_PRICE = CPrice::GetBasePrice($ID);
            $PRICE = $BASE_PRICE['PRICE'];
            //CPrice::SetBasePrice($id, $tp["PRICE"], 'RUB');

            $AMOUNT = 'default';

            //когда больше
            if ($PRICE_LIMIT >= 28000) {
                $proc = $PRICE / 100 * 10;
                if ($proc > 0) {
                    $PRICE = $PRICE + $proc;
                }
                CPrice::SetBasePrice($ID, $PRICE, 'RUB');
            }
            else {
                CPrice::SetBasePrice($ID, 0, 'RUB');

                //Магазин в Санкт-Петербурге
                $arProdFields = Array(
                    "PRODUCT_ID" => $ID,
                    "STORE_ID" => 6,
                    "AMOUNT" => 0,
                );
                CCatalogStoreProduct::UpdateFromForm($arProdFields);

                //Удаленный склад
                $arProdFields = Array(
                    "PRODUCT_ID" => $ID,
                    "STORE_ID" => 5,
                    "AMOUNT" => 0,
                );
                CCatalogStoreProduct::UpdateFromForm($arProdFields);
                $AMOUNT = 0;
            }

            CIBlockElement::SetPropertyValueCode($ID, "PRICE_LIMIT", '');

            echo $CML2_ARTICLE.'='.$PRICE_LIMIT.'=PRICE'.$PRICE.'=AMOUNT='.$AMOUNT;

            echo '<br>';
        }
    }
    else {
        echo '--------'.$CML2_ARTICLE.'='.$PRICE_LIMIT;
        echo '<br>';
        continue;
    }    
}


require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_after.php');
