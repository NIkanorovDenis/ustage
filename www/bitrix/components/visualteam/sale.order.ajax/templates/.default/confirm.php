<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Sale;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Internals\OrderPropsValueTable;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y") {
    $APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<? if (!empty($arResult["ORDER"])): ?>

    <table class="sale_order_full_table">
        <tr>
            <td>
                <?= Loc::getMessage("SOA_ORDER_SUC", array(
                    "#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
                    "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
                )) ?>
                <? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
                    <?= Loc::getMessage("SOA_PAYMENT_SUC", array(
                        "#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
                    )) ?>
                <? endif ?>
                <? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
                    <br/><br/>
                    <?= Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']]) ?>
                <? endif; ?>
            </td>
        </tr>
    </table>
    <?


    CModule::IncludeModule('crm'); //crm
    CModule::IncludeModule("tasks"); //задачи
    CModule::IncludeModule('bizproc'); //бизнес-процессы
    CModule::IncludeModule('sale');

    global $DB;
    $arOrder = CSaleOrder::GetByID($arResult["ORDER"]["ID"]);
    $total = $arOrder["PRICE"];

    $order = Sale\Order::load( $arResult["ORDER"]["ID"]);

    $propertyCollection = $order->getPropertyCollection();

    $bonusCardNumber = '';

    $orderProps = OrderPropsValueTable::getList([
      'filter' => [
        'ORDER_ID' => $arResult['ORDER']['ID'],
      ],
    ]);

    while ($orderProp = $orderProps->fetch()) {
      if ($orderProp['CODE'] === 'BONUS_CARD_NUMBER') {
        $bonusCardNumber = $orderProp['VALUE'];
        break;
      }
    }

	$tdata = $DB->Query("SELECT * FROM b_sale_order_props_value WHERE ORDER_PROPS_ID= 12 AND ORDER_ID=".$arResult["ORDER"]["ID"]);
	$tinfo = $tdata->Fetch();
	$uname = $tinfo["VALUE"];

	$tdata = $DB->Query("SELECT * FROM b_sale_order_props_value WHERE ORDER_PROPS_ID= 13 AND ORDER_ID=".$arResult["ORDER"]["ID"]);
	$tinfo = $tdata->Fetch();
	$umail = $tinfo["VALUE"];

	$tdata = $DB->Query("SELECT * FROM b_sale_order_props_value WHERE ORDER_PROPS_ID= 14 AND ORDER_ID=".$arResult["ORDER"]["ID"]);
	$tinfo = $tdata->Fetch();
	$uphone = $tinfo["VALUE"];

    $arNewCompany = array(
        "TITLE" =>  $uname,
        "OPENED" => "Y",
        "COMPANY_TYPE" => "CUSTOMER",
        "ASSIGNED_BY_ID" => 269

    );
    $arNewCompany['FM']['PHONE'] = array(
        'n0' => array(
            'VALUE_TYPE' => 'WORK',
            'VALUE' =>  $uphone,
        )
    );
    $arNewCompany['FM']['EMAIL'] = array(
        'n0' => array(
            'VALUE_TYPE' => 'WORK',
            'VALUE' =>  $umail,
        )
    );
    $company = new CCrmCompany(false);
    $companyID = $company->Add($arNewCompany);


    $ct=new CCrmContact(false);
    $arNewClient = array(
        "NAME" =>  $uname,
        "OPENED" => "Y",
        "TYPE_ID" => "CLIENT",
        "PHONE" => Array('n0' => array(
            'VALUE_TYPE' => 'WORK',
            'VALUE' =>  $uphone)
        ),
        "EMAIL"  => Array('n0' => array(
            'VALUE_TYPE' => 'WORK',
            'VALUE' =>  $umail)
        ),

    );

    $ctID = $ct->Add($arNewClient);

    $arFields = array(
        "TITLE" => "Заказ № " . $arResult["ORDER"]["ACCOUNT_NUMBER"],
        "TYPE_ID" => "SALE",
        "STAGE_ID" => "NEW",
        "COMPANY_ID" => $companyID,
        "OPENED" => "Y",
        "OPPORTUNITY" => $arOrder["PRICE"],
        "ASSIGNED_BY_ID" => 269

    );
//$options = array('CURRENT_USER'=>1); //из под админа
    $deal = new CCrmDeal(false);
    $arErrorsTmp = Array();
    $dealId = $deal->Add($arFields, true);

	\Bitrix\Crm\Automation\Factory::runOnAdd(\CCrmOwnerType::Deal, $dealId);


    $res = CSaleBasket::GetList(array(), array("ORDER_ID" => $arResult["ORDER"]["ID"])); // ID заказа
    $rows = array();


    while ($arItem = $res->Fetch()) {

        $rows[] = array(
            'PRODUCT_NAME' => $arItem['NAME'], 'QUANTITY' => $arItem['QUANTITY'],   'PRICE' => $arItem['PRICE'], 'PRODUCT_ID' => $arItem['PRODUCT_ID'],

        );

    }
    CCrmProductRow::SaveRows('D', $dealId, $rows);

    $DB->Query("UPDATE b_crm_deal SET OPPORTUNITY='".$arOrder["PRICE"]."'    WHERE ID=".$dealId);


    $data = $DB->Query("SELECT * FROM b_sale_order_props_value WHERE ORDER_PROPS_ID=6 AND ORDER_ID=".$arResult["ORDER"]["ID"]);
    $info = $data->Fetch();

    $locID = 0;
    if(isset($info["VALUE"]))
    {
        $locID = $info["VALUE"];

		$locdata = $DB->Query("SELECT * FROM b_sale_location WHERE CODE ='".$locID."'");
		$locinfo = $locdata->Fetch();

		$finaldata = $DB->Query("SELECT * FROM b_sale_loc_name WHERE LOCATION_ID=". $locinfo["ID"]);
		$item = $finaldata->Fetch();

        $city = $item['NAME'];

		$tdata = $DB->Query("UPDATE b_uts_crm_deal SET UF_CRM_1613726555 ='".$city."' WHERE VALUE_ID=".$dealId);
    }

    $data = $DB->Query("SELECT * FROM b_sale_order WHERE ID=".$arResult["ORDER"]["ID"]);
	$info = $data->Fetch();

	if($info["PERSON_TYPE_ID"] == 1)
		$typeinfo = 101;
	else
		$typeinfo = 102;
	$tdata = $DB->Query("UPDATE b_uts_crm_deal SET UF_CRM_1613726469 ='".$typeinfo."' WHERE VALUE_ID=".$dealId);

	$deliveryID = 109;
	if($info["DELIVERY_ID"] == 11)
		$deliveryID = 111;

	if($info["DELIVERY_ID"] == 1)
		$deliveryID = 109;

	if($info["DELIVERY_ID"] == 2)
		$deliveryID = 108;

	$tdata =  $DB->Query("UPDATE b_uts_crm_deal SET UF_CRM_1613726795 ='".$deliveryID."' WHERE VALUE_ID=".$dealId);

  $tdata = $DB->Query("UPDATE b_uts_crm_deal SET UF_CRM_1644413067634 ='".$bonusCardNumber."' WHERE VALUE_ID=".$dealId);

	$tdata = $DB->Query("UPDATE b_uts_crm_deal SET UF_CRM_1618820544957 ='".$uname."',
	 UF_CRM_1618820556459 ='".$umail."',
	 UF_CRM_1618820565885 ='".$uphone."'
	 WHERE VALUE_ID=".$dealId);

    $DATA_LAYER = @$_SESSION['DATA_LAYER_NEW'.$arOrder['ID']];

    //ОТПРАВКА В ЯНДЕКС МЕТРИКУ 
    if (empty($DATA_LAYER)) {

        $_SESSION['DATA_LAYER_NEW'.$arOrder['ID']] = 1;

        //ЗДЕСЬ только ДЛЯ ЗАКАЗОВ В ОДИН КЛИК
        //if (empty($arOrder['PAY_SYSTEM_ID']) && empty($arOrder['DELIVERY_ID'])) {
        if (1 == 1) {
            ?>
            <script>
            $(document).ready(function(){
                dataLayer.push({
                    'ecommerce': {
                        'currencyCode': 'RUB',
                        'purchase': {
                            'actionField': {
                                'id' : '<?= $arOrder['ID'] ?>'
                            },
                            'products': [
                                <? $i = 1;
                                foreach ($rows AS $item) {

                                    $res = CIBlockElement::GetList( 
                                        Array('SORT' => 'ASC', 'ID' => 'ASC'),
                                        Array('IBLOCK_ID' =>array('32', '33'), 'ID' => $item['PRODUCT_ID'])
                                    );
                                    while($row = $res->GetNextElement()) {
                                        $arFields = $row->GetFields(); 
                                        $arProp = $row->GetProperties(); 

                                        $brand = ucfirst($arProp['MANUFACTURER']['VALUE']);

                                        $item_price = number_format($item['PRICE'], 2, '.', '');

                                        $SECTION_NAME = '';
                                        $SECTION_ID = $arFields['IBLOCK_SECTION_ID'];
                                        $section_res = CIBlockSection::GetList( 
                                            Array('SORT' => 'ASC', 'ID' => 'ASC'),
                                            Array('IBLOCK_ID' =>'32', 'ID' => $SECTION_ID)
                                        );
                                        while($section_row = $section_res->GetNextElement()) {
                                            $arFieldsSec = $section_row->GetFields(); 
                                            $SECTION_NAME =  $arFieldsSec['NAME'];
                                            break;
                                        }

                                        $brand = ucfirst($arProp['MANUFACTURER']['VALUE']);

                                        $QUANTITY = (int)$item['QUANTITY'];

                                        echo "{
                                            'id': '".$arOrder['ID']."',
                                            'name': '".$item['PRODUCT_NAME']."',
                                            'price': '".$item_price."',
                                            'brand': '".$brand."',
                                            'category': '".$SECTION_NAME."',
                                            'variant': '',
                                            'quantity': '".$QUANTITY."'
                                        }";
                                        if (count($rows) <> $i) echo ",";
                                    }
                                    $i++;
                                }
                                ?>
                            ]
                        }
                    }
                });
            });
            </script>
            <?
        }
    }

/*
    $newTask = array(
        "TITLE" => "Взять сделку в работу",
        "DESCRIPTION" => "Взять сделку в работу",
        "RESPONSIBLE_ID" => 269,//ответственный
        //"TASK_CONTROL" => "Y",
        "ADD_IN_REPORT" => "Y",

        "UF_CRM_TASK" => Array("D_".$dealId) //ID сделки
    );



    $taskItem = \CTaskItem::add($newTask, 269);
*/
    /*
    print_r("<pre>");
    print_r($dealId);
    print_r($newTask);
    print_r($taskItem);
    print_r("</pre>");
*/
    ?>
    <?
    if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y') {
        if (!empty($arResult["PAYMENT"])) {
            foreach ($arResult["PAYMENT"] as $payment) {
                if ($payment["PAID"] != 'Y') {
                    if (!empty($arResult['PAY_SYSTEM_LIST'])
                        && array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
                    ) {
                        $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

                        if (empty($arPaySystem["ERROR"])) {
                            ?>
                            <br/><br/>

                            <table class="sale_order_full_table">
                                <tr>
                                    <td class="ps_logo">
                                        <div class="pay_name"><?= Loc::getMessage("SOA_PAY") ?></div>
                                        <?= CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
                                        <div class="paysystem_name"><?= $arPaySystem["NAME"] ?></div>
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                                            <?
                                            $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                                            $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                                            ?>
                                            <script>
                                                window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
                                            </script>
                                        <?= Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&PAYMENT_ID=" . $paymentAccountNumber)) ?>
                                        <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
                                        <br/>
                                            <?= Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&pdf=1&DOWNLOAD=Y")) ?>
                                        <? endif ?>
                                        <? else: ?>
                                            <?= $arPaySystem["BUFFERED_OUTPUT"] ?>
                                        <? endif ?>
                                    </td>
                                </tr>
                            </table>

                            <?
                        } else {
                            ?>
                            <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                            <?
                        }
                    } else {
                        ?>
                        <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                        <?
                    }
                }
            }
        }
    } else {
        ?>
        <br/><strong><?= $arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] ?></strong>
        <?
    }
    ?>

<? else: ?>

    <b><?= Loc::getMessage("SOA_ERROR_ORDER") ?></b>
    <br/><br/>

    <table class="sale_order_full_table">
        <tr>
            <td>
                <?= Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])]) ?>
                <?= Loc::getMessage("SOA_ERROR_ORDER_LOST1") ?>
            </td>
        </tr>
    </table>

<? endif ?>
