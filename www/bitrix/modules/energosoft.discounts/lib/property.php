<?
namespace Energosoft\Discounts;

use \Bitrix\Sale\Discount\Formatter;
use \Bitrix\Sale\Discount\Actions;
use \Bitrix\Currency\CurrencyManager;
use \Bitrix\Main\Localization\Loc;

\Bitrix\Main\Loader::includeModule('sale');

class Property extends \CSaleActionCtrlBasketGroup
{
	public static function GetControlDescr()
	{
		$description = parent::GetControlDescr();
		$description['SORT'] = 10;
		return $description;
	}

	public static function GetControlID()
	{
		return 'ESDiscountsProperty';
	}

	public static function GetControlShow($arParams)
	{
		$arAtoms = static::GetAtomsEx(false, false);
		return array(
			'controlId' => static::GetControlID(),
			'group' => false,
			'label' => Loc::getMessage('ENERGOSOFT.DISCOUNTS_DISCOUNT'),
			'defaultText' => '',
			'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
			'control' => array(
				$arAtoms['Extra'],
				$arAtoms['Type'],
				Loc::getMessage('ENERGOSOFT.DISCOUNTS_CURRENCY'),
				$arAtoms['Currency'],
				Loc::getMessage('ENERGOSOFT.DISCOUNTS_PROPERTY'),
				$arAtoms['PropertyCode'],
				Loc::getMessage('ENERGOSOFT.DISCOUNTS_MAX'),
				$arAtoms['Max'],
				//Loc::getMessage('ENERGOSOFT.DISCOUNTS_MIN'),
				//$arAtoms['Min'],
			),
		);
	}

	public static function GetAtoms()
	{
		return self::GetAtomsEx(false, false);
	}

	public static function GetAtomsEx($strControlID = false, $boolEx = false)
	{
		$boolEx = (true === $boolEx ? true : false);

		$arCurrency = \Bitrix\Currency\CurrencyManager::getCurrencyList();
		$baseCurrency = \Bitrix\Currency\CurrencyManager::getBaseCurrency();

		$arAtomList = array(
			'Extra' => array(
				'JS' => array(
					'id' => 'Extra',
					'name' => 'extra',
					'type' => 'select',
					'values' => array(
						'discount' => Loc::getMessage('ENERGOSOFT.DISCOUNTS_DISCOUNT_DISCOUNT'),
						//'extra' => Loc::getMessage('ENERGOSOFT.DISCOUNTS_DISCOUNT_EXTRA'),
						//'price' => Loc::getMessage('ENERGOSOFT.DISCOUNTS_DISCOUNT_PRICE'),
					),
					'defaultText' => Loc::getMessage('ENERGOSOFT.DISCOUNTS_DISCOUNT_DISCOUNT'),
					'defaultValue' => 'discount',
					'first_option' => '...',
				),
				'ATOM' => array(
					'ID' => 'Extra',
					'FIELD_TYPE' => 'string',
					'FIELD_LENGTH' => 20,
					'MULTIPLE' => 'N',
					'VALIDATE' => 'list',
				),
			),
			'Type' => array(
				'JS' => array(
					'id' => 'Type',
					'name' => 'type',
					'type' => 'select',
					'values' => array(
						'fix' => Loc::getMessage('ENERGOSOFT.DISCOUNTS_TYPE_FIX'),
						'percent' => Loc::getMessage('ENERGOSOFT.DISCOUNTS_TYPE_PERCENT'),
					),
					'defaultText' => Loc::getMessage('ENERGOSOFT.DISCOUNTS_TYPE_FIX'),
					'defaultValue' => 'fix',
					'first_option' => '...',
				),
				'ATOM' => array(
					'ID' => 'Type',
					'FIELD_TYPE' => 'string',
					'FIELD_LENGTH' => 25,
					'MULTIPLE' => 'N',
					'VALIDATE' => 'list',
				),
			),
			'Currency' => array(
				'JS' => array(
					'id' => 'Currency',
					'name' => 'currency',
					'type' => 'select',
					'values' => $arCurrency,
					'defaultText' => $arCurrency[$baseCurrency],
					'defaultValue' => $baseCurrency,
					'first_option' => '...',
				),
				'ATOM' => array(
					'ID' => 'Currency',
					'FIELD_TYPE' => 'string',
					'FIELD_LENGTH' => 5,
					'MULTIPLE' => 'N',
					'VALIDATE' => 'list',
				),
			),
			'PropertyCode' => array(
				'JS' => array(
					'id' => 'PropertyCode',
					'name' => 'property_code',
					'type' => 'input',
					'defaultValue' => 'DISCOUNT',
				),
				'ATOM' => array(
					'ID' => 'PropertyCode',
					'FIELD_TYPE' => 'string',
					'FIELD_LENGTH' => 255,
					'MULTIPLE' => 'N',
					'VALIDATE' => '',
				),
			),
//			'Min' => array(
//				'JS' => array(
//					'id' => 'Min',
//					'name' => 'min',
//					'type' => 'input',
//					'defaultValue' => '',
//					'defaultText' => '...',
//				),
//				'ATOM' => array(
//					'ID' => 'Min',
//					'FIELD_TYPE' => 'string',
//					'FIELD_LENGTH' => 5,
//					'MULTIPLE' => 'N',
//					'VALIDATE' => '',
//				),
//			),
			'Max' => array(
				'JS' => array(
					'id' => 'Max',
					'name' => 'max',
					'type' => 'input',
					'defaultValue' => '',
					'defaultText' => '...',
				),
				'ATOM' => array(
					'ID' => 'Max',
					'FIELD_TYPE' => 'string',
					'FIELD_LENGTH' => 5,
					'MULTIPLE' => 'N',
					'VALIDATE' => '',
				),
			),
		);

		if(!$boolEx)
		{
			foreach($arAtomList as &$arOneAtom) $arOneAtom = $arOneAtom['JS'];
			if(isset($arOneAtom)) unset($arOneAtom);
		}

		return $arAtomList;
	}

	public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
	{
		$arAtoms = static::GetAtomsEx(false, false);
		$discountParams = array(
			'VALUE' => 0,
			'LIMIT_VALUE' => $arOneCondition[$arAtoms['Max']['id']],
			'UNIT' => $arOneCondition[$arAtoms['Type']['id']] == 'percent' ? Actions::VALUE_TYPE_PERCENT : Actions::VALUE_TYPE_FIX,
			'LIMIT_VALUE_MIN' => $arOneCondition[$arAtoms['Min']['id']],
			'PROPERTY_CODE' => $arOneCondition[$arAtoms['PropertyCode']['id']],
			'TYPE' => $arOneCondition[$arAtoms['Type']['id']],
			'EXTRA' => $arOneCondition[$arAtoms['Extra']['id']],
			'CURRENCY' => $arOneCondition[$arAtoms['Currency']['id']],
		);
		$mxResult = 'if(is_callable(array(\'\\'.__CLASS__.'\',\'applyToBasket\'))) \\'.__CLASS__.'::applyToBasket('.$arParams['ORDER'].', '.var_export($discountParams, true).', "");';
		$result = array('COND' => $mxResult);
		if($arOneCondition['Unit'] === Actions::VALUE_TYPE_SUMM) $result['OVERWRITE_CONTROL'] = array('EXECUTE_MODULE' => 'sale');
		return $result;
	}

	public static function applyToBasket(&$order, $action, $filter)
	{
		if(!$action['PROPERTY_CODE'] || !$action['EXTRA']) return;

		Actions::increaseApplyCounter();

		if(!isset($action['VALUE']) || !isset($action['UNIT'])) return;

		$orderCurrency = Actions::getCurrency();
		$limitValue = floatval($action['LIMIT_VALUE']);
		$limitValueMin = floatval($action['LIMIT_VALUE_MIN']);
		$type = $action['TYPE'];
		$extra = $action['EXTRA'];
		$unit = $action['UNIT'];
		$currency = (isset($action['CURRENCY']) ? $action['CURRENCY'] : ($orderCurrency));

		$actionDescription = array('ACTION_TYPE' => Formatter::TYPE_VALUE);
		if($unit == Actions::VALUE_TYPE_PERCENT)
		{
			$actionDescription['VALUE_TYPE'] = Formatter::VALUE_TYPE_PERCENT;
		}
		else
		{
			$actionDescription['VALUE_TYPE'] = Formatter::VALUE_TYPE_CURRENCY;
			$actionDescription['VALUE_UNIT'] = $currency;
		}

		if(empty($order['BASKET_ITEMS']) || !is_array($order['BASKET_ITEMS'])) return;

		Actions::enableBasketFilter();
		$filteredBasket = Actions::getBasketForApply($order['BASKET_ITEMS'], $filter, $action);
		if(empty($filteredBasket)) return;

		$applyBasket = array_filter($filteredBasket, '\Bitrix\Sale\Discount\Actions::filterBasketForAction');
		unset($filteredBasket);
		if(empty($applyBasket)) return;

		$totalCalculateValue = 0.0;

		foreach($applyBasket as $basketCode => $basketRow)
		{
			if(\Bitrix\Main\Loader::includeModule('iblock'))
			{
				$value = 0.0;
				$rsElement = \Bitrix\Iblock\ElementTable::getList(array(
					'filter' => array('=ID'=>intval($basketRow['PRODUCT_ID'])),
					'select' => array('ID','IBLOCK_ID'),
				));
				if($element = $rsElement->fetch())
				{
					$rsProp = \CIBlockElement::GetProperty($element["IBLOCK_ID"], $element["ID"], array(), array("CODE"=>$action['PROPERTY_CODE']));
					if($prop = $rsProp->Fetch())
					{
						$value = ($action['EXTRA'] == 'discount' ? -1 : 1) * floatval($prop['VALUE']);
						if($type == 'percent')
						{
							$vv = abs($value);
							$value = 0;
							if($vv >= 29 && $vv <= 31) $value = -7;
							if($vv >= 32 && $vv <= 35) $value = -10;
							if($vv >= 57) $value = -20;
						}
					}
				}
			}

			$rowActionDescription = $actionDescription;

			if($type == 'fix' && $currency != $orderCurrency) $value = \CCurrencyRates::ConvertCurrency($value, $currency, $orderCurrency);

			if($extra == 'discount' || $extra == 'extra')
			{
				if($unit == Actions::VALUE_TYPE_SUMM)
				{
					$value = Actions::getPercentByValue($applyBasket, $value);
					if(
						($valueAction == Formatter::VALUE_ACTION_DISCOUNT && ($value >= 0 || $value < -100))
						||
						($valueAction == Formatter::VALUE_ACTION_EXTRA && $value <= 0)
					)
						return;
					$unit = Actions::VALUE_TYPE_PERCENT;
				}
				$value = Actions::roundZeroValue($value);
				if($value == 0) continue;

				$calculateValue = $value;
				if($unit == Actions::VALUE_TYPE_PERCENT) $calculateValue = Actions::percentToValue($basketRow, $calculateValue);
				$calculateValue = Actions::roundValue($calculateValue, $basketRow['CURRENCY']);

				if(!empty($limitValue) && abs($calculateValue) > $limitValue)
				{
					$calculateValue = ($calculateValue < 0 ? -1 : 1) * $limitValue;
					$rowActionDescription['ACTION_TYPE'] = Formatter::TYPE_LIMIT_VALUE;
					$rowActionDescription['LIMIT_TYPE'] = Formatter::LIMIT_MAX;
					$rowActionDescription['LIMIT_UNIT'] = $orderCurrency;
					$rowActionDescription['LIMIT_VALUE'] = $limitValue;
				}

				if(!empty($limitValueMin) && abs($calculateValue) < $limitValueMin)
				{
					$calculateValue = ($calculateValue < 0 ? -1 : 1) * $limitValueMin;
					$rowActionDescription['ACTION_TYPE'] = Formatter::TYPE_LIMIT_VALUE;
					$rowActionDescription['LIMIT_TYPE'] = Formatter::LIMIT_MIN;
					$rowActionDescription['LIMIT_UNIT'] = $orderCurrency;
					$rowActionDescription['LIMIT_VALUE'] = $limitValueMin;
				}

				$result = Actions::roundZeroValue($basketRow['PRICE'] + $calculateValue);
			}
			elseif($extra == 'price')
			{
				if($value == 0) continue;
				$basePrice = Actions::percentToValue($basketRow, 100);

				if($unit == Actions::VALUE_TYPE_PERCENT) $result = Actions::percentToValue($basketRow, $value);
				else $result = Actions::roundZeroValue($value);

				if(!empty($limitValue) && $result > $limitValue)
				{
					$result = $limitValue;
					$rowActionDescription['ACTION_TYPE'] = Formatter::TYPE_LIMIT_VALUE;
					$rowActionDescription['LIMIT_TYPE'] = Formatter::LIMIT_MAX;
					$rowActionDescription['LIMIT_UNIT'] = $orderCurrency;
					$rowActionDescription['LIMIT_VALUE'] = $limitValue;
				}

				if(!empty($limitValueMin) && $result < $limitValueMin)
				{
					$result = $limitValueMin;
					$rowActionDescription['ACTION_TYPE'] = Formatter::TYPE_LIMIT_VALUE;
					$rowActionDescription['LIMIT_TYPE'] = Formatter::LIMIT_MIN;
					$rowActionDescription['LIMIT_UNIT'] = $orderCurrency;
					$rowActionDescription['LIMIT_VALUE'] = $limitValueMin;
				}

				$calculateValue = $result - $basePrice;
			}

			$rowActionDescription['VALUE'] = abs($calculateValue);
			$rowActionDescription['VALUE_ACTION'] = $calculateValue < 0 ? Formatter::VALUE_ACTION_DISCOUNT : Formatter::VALUE_ACTION_EXTRA;

			$totalCalculateValue += $calculateValue;

			if($result >= 0)
			{
				self::fillDiscountPrice($basketRow, $result, -$calculateValue);

				$order['BASKET_ITEMS'][$basketCode] = $basketRow;

				$rowActionDescription['BASKET_CODE'] = $basketCode;
				$rowActionDescription['RESULT_VALUE'] = abs($calculateValue);
				$rowActionDescription['RESULT_UNIT'] = $orderCurrency;

				Actions::setActionResult(Actions::RESULT_ENTITY_BASKET, $rowActionDescription);
				unset($rowActionDescription);
			}
			unset($result);
		}
		unset($basketCode, $basketRow);

		$actionDescription['VALUE'] = abs($totalCalculateValue);
		$actionDescription['VALUE_ACTION'] = $totalCalculateValue < 0 ? Formatter::VALUE_ACTION_DISCOUNT : Formatter::VALUE_ACTION_EXTRA;

		Actions::setActionDescription(Actions::RESULT_ENTITY_BASKET, $actionDescription);
	}

	protected static function fillDiscountPrice(array &$basketRow, $price, $discount)
	{
		if(!isset($basketRow['DISCOUNT_PRICE'])) $basketRow['DISCOUNT_PRICE'] = 0;
		$basketRow['PRICE'] = $price;
		$basketRow['DISCOUNT_PRICE'] += $discount;
	}
}
?>