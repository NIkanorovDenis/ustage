<?
namespace Energosoft\Discounts;

class Events
{
	public static function OnDiscountAfterUpdate(\Bitrix\Main\ORM\Event $event)
	{
		GLOBAL $DB;
		$id = $event->getParameter('primary');
		$fields = $event->getParameter('fields');

		$arCheck = DiscountsHelper::Search($fields, "CLASS_ID", "ESDiscountsProperty");
		if(count($arCheck) == 1)
		{
			if($arCheck[0]["DATA"]["Extra"] == "discount")
			{
				$arDescription = array(
					'TYPE' => 'Discount',
					'VALUE' => 0,
					'LIMIT_VALUE' => 0,
					'VALUE_TYPE' => 'P',
				);
				if($arCheck[0]["DATA"]["Type"] == "fix") $arDescription["VALUE_TYPE"] = "F";
				if($arCheck[0]["DATA"]["Type"] == "percent") $arDescription["VALUE_TYPE"] = "P";
				if(floatval($arCheck[0]["DATA"]["Max"]) > 0) $arDescription["LIMIT_VALUE"] = $arCheck[0]["DATA"]["Max"];
				$DB->Query("UPDATE b_sale_discount SET SHORT_DESCRIPTION='".serialize($arDescription)."' WHERE ID=".intval($id["ID"]));
			}
		}
	}

    public static function OnGetDiscount($intProductID, $intIBlockID, $arCatalogGroups, $arUserGroups, $strRenewal, $siteID, $arDiscountCoupons, $boolSKU, $boolGetIDS)
	{
		GLOBAL $ES_DISCOUNT_PRODUCT_ID;
		$ES_DISCOUNT_PRODUCT_ID = $intProductID;
		return true;
	}

    public static function OnGetDiscountResult(&$arResult)
	{
		GLOBAL $ES_DISCOUNT_PRODUCT_ID;
		if(intval($ES_DISCOUNT_PRODUCT_ID) > 0)
		{
			foreach($arResult as $k=>$arItem)
			{
				$arDiscount = \Bitrix\Sale\Internals\DiscountTable::getById($k)->fetch();
				$arCheck = DiscountsHelper::Search($arDiscount["ACTIONS_LIST"], "CLASS_ID", "ESDiscountsProperty");
				if(count($arCheck) == 1)
				{
					if(\Bitrix\Main\Loader::includeModule('iblock'))
					{
						$rsElement = \Bitrix\Iblock\ElementTable::getList(array(
							'filter' => array('=ID'=>$ES_DISCOUNT_PRODUCT_ID),
							'select' => array('ID','IBLOCK_ID'),
						));
						if($element = $rsElement->fetch())
						{
							$rsProp = \CIBlockElement::GetProperty($element['IBLOCK_ID'], $element['ID'], array(), array("CODE"=>$arCheck[0]['DATA']['PropertyCode']));
							if($prop = $rsProp->Fetch())
							{
								if(floatval($prop['VALUE']) != 0)
								{
									$arResult[$k]["VALUE"] = floatval($prop['VALUE']);
									if($arCheck[0]["DATA"]["Type"] == "fix") $arResult[$k]["VALUE_TYPE"] = "F";
									if($arCheck[0]["DATA"]["Type"] == "percent")
									{
										$arResult[$k]["VALUE_TYPE"] = "P";

										$vv = abs($arResult[$k]["VALUE"]);
										$arResult[$k]["VALUE"] = 0;
										if($vv >= 29 && $vv <= 31) $arResult[$k]["VALUE"] = 7;
										if($vv >= 32 && $vv <= 35) $arResult[$k]["VALUE"] = 10;
										if($vv >= 57) $arResult[$k]["VALUE"] = 20;
									}
									if(floatval($arCheck[0]["DATA"]["Max"]) > 0)
									{
										if($arCheck[0]["DATA"]["Type"] == "fix" && floatval($prop['VALUE']) > floatval($arCheck[0]["DATA"]["Max"]))
										{
											$arResult[$k]["VALUE"] = floatval($arCheck[0]["DATA"]["Max"]);
											$arResult[$k]["MAX_DISCOUNT"] = floatval($arCheck[0]["DATA"]["Max"]);
										}
										else
											$arResult[$k]["MAX_DISCOUNT"] = floatval($arCheck[0]["DATA"]["Max"]);
									}
								}
							}
						}
					}
				}
			}
		}
		$ES_DISCOUNT_PRODUCT_ID = 0;
	}
}
?>