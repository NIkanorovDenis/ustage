<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale;
use Bitrix\Sale\Delivery;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Sale\Location\GeoIp;
use Bitrix\Sale\Location\LocationTable;
use Bitrix\Sale\Order;
use Bitrix\Sale\Payment;
use Bitrix\Sale\PaySystem;
use Bitrix\Sale\PersonType;
use Bitrix\Sale\Result;
use Bitrix\Sale\Services\Company;
use Bitrix\Sale\Shipment;
use Bitrix\Sale\BasketItemBase;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

/**
 * @var $APPLICATION CMain
 * @var $USER CUser
 */

Loc::loadMessages(__FILE__);

if (!Loader::includeModule("sale")) {
	ShowError(Loc::getMessage("SOA_MODULE_NOT_INSTALL"));

	return;
}

CBitrixComponent::includeComponentClass("bitrix:sale.order.ajax");

class SaleOrderAjaxExtended extends SaleOrderAjax
{
  public function obtainBasket()
  {
    $arResult =& $this->arResult;

    $arResult["MAX_DIMENSIONS"] = $arResult["ITEMS_DIMENSIONS"] = array();
    $arResult["BASKET_ITEMS"] = array();

    $this->calculateBasket = $this->order->getBasket()->createClone();

    $discounts = $this->order->getDiscount();
    $showPrices = $discounts->getShowPrices();

    if (!empty($showPrices['BASKET'])) {
      foreach ($showPrices['BASKET'] as $basketCode => $data) {
        $basketItem = $this->calculateBasket->getItemByBasketCode($basketCode);

        if ($basketItem instanceof BasketItemBase) {
          $basketItem->setFieldNoDemand('BASE_PRICE', $data['SHOW_BASE_PRICE']);
          $basketItem->setFieldNoDemand('PRICE', $data['SHOW_PRICE']);
          $basketItem->setFieldNoDemand('DISCOUNT_PRICE', $data['SHOW_DISCOUNT']);
        }
      }
    }

    /** @var Sale\BasketItem $basketItem */
    foreach ($this->calculateBasket as $basketItem) {
      $arBasketItem = $basketItem->getFieldValues();

      if ($basketItem->getVatRate() > 0) {
        $arResult["bUsingVat"] = "Y";
        $arBasketItem["VAT_VALUE"] = $basketItem->getVat();
      }

      $arBasketItem["QUANTITY"] = $basketItem->getQuantity();

      $arBasketItem["PRICE_FORMATED"] = SaleFormatCurrency($basketItem->getPrice(), $this->order->getCurrency());

      $arBasketItem["WEIGHT_FORMATED"] = roundEx(doubleval($basketItem->getWeight()/$arResult["WEIGHT_KOEF"]), SALE_WEIGHT_PRECISION)." ".$arResult["WEIGHT_UNIT"];

      $arBasketItem["DISCOUNT_PRICE"] = $basketItem->getDiscountPrice();

      $arBasketItem["DISCOUNT_PRICE_PERCENT"] = 0;

      if ($arBasketItem['CUSTOM_PRICE'] != 'Y') {
        $arBasketItem['DISCOUNT_PRICE_PERCENT'] = Sale\Discount::calculateDiscountPercent(
          $arBasketItem['BASE_PRICE'],
          $arBasketItem['DISCOUNT_PRICE']
        );

        if ($arBasketItem['DISCOUNT_PRICE_PERCENT'] === null) {
          $arBasketItem['DISCOUNT_PRICE_PERCENT'] = 0;
        }
      }

      $arBasketItem["DISCOUNT_PRICE_PERCENT_FORMATED"] = $arBasketItem['DISCOUNT_PRICE_PERCENT'].'%';

      $arBasketItem["BASE_PRICE_FORMATED"] = SaleFormatCurrency($basketItem->getBasePrice(), $this->order->getCurrency());

      $arDim = unserialize($basketItem->getField('DIMENSIONS'));

      if (is_array($arDim)) {
        $arResult["MAX_DIMENSIONS"] = CSaleDeliveryHelper::getMaxDimensions(array(
          $arDim["WIDTH"],
          $arDim["HEIGHT"],
          $arDim["LENGTH"]
        ), $arResult["MAX_DIMENSIONS"]);

        $arResult["ITEMS_DIMENSIONS"][] = $arDim;
      }

      $arBasketItem["PROPS"] = array();

      /** @var Sale\BasketPropertiesCollection $propertyCollection */

      $propertyCollection = $basketItem->getPropertyCollection();
      $propList = $propertyCollection->getPropertyValues();

      foreach ($propList as $key => &$prop) {
        if ($prop['CODE'] == 'CATALOG.XML_ID' || $prop['CODE'] == 'PRODUCT.XML_ID' || $prop['CODE'] == 'SUM_OF_CHARGE') {
          continue;
        }

        $prop = array_filter($prop, array("CSaleBasketHelper", "filterFields"));
        $arBasketItem["PROPS"][] = $prop;
      }

      $this->arElementId[] = $arBasketItem["PRODUCT_ID"];

      $arBasketItem["SUM_NUM"] = $basketItem->getPrice() * $basketItem->getQuantity();
      $arBasketItem["SUM"] = SaleFormatCurrency($basketItem->getPrice() * $basketItem->getQuantity(), $this->order->getCurrency());
      $arBasketItem["SUM_BASE"] = $basketItem->getBasePrice() * $basketItem->getQuantity();
      $arBasketItem["SUM_BASE_FORMATED"] = SaleFormatCurrency($basketItem->getBasePrice() * $basketItem->getQuantity(), $this->order->getCurrency());
      $arBasketItem['REAL_BASE_PRICE'] = $showPrices['BASKET'][$basketItem->getId()]['REAL_BASE_PRICE'];
      $arBasketItem["REAL_BASE_PRICE_FORMATED"] = SaleFormatCurrency($arBasketItem["REAL_BASE_PRICE"], $this->order->getCurrency());
      $arBasketItem['REAL_PRICE'] = $showPrices['BASKET'][$basketItem->getId()]['REAL_PRICE'];
      $arBasketItem['REAL_DISCOUNT'] = $showPrices['BASKET'][$basketItem->getId()]['REAL_DISCOUNT'];
      $arBasketItem["SUM_REAL_BASE"] = $arBasketItem['REAL_BASE_PRICE'] * $basketItem->getQuantity();
      $arBasketItem["SUM_REAL_BASE_FORMATED"] = SaleFormatCurrency($arBasketItem["SUM_REAL_BASE"], $this->order->getCurrency());

      $arResult["BASKET_ITEMS"][] = $arBasketItem;
    }

    unset($showPrices); // Moved.SE
  }

  protected function obtainTotal()
  {
    $arResult =& $this->arResult;

    $locationAltPropDisplayManual = $this->request->get('LOCATION_ALT_PROP_DISPLAY_MANUAL');

    if (!empty($locationAltPropDisplayManual) && is_array($locationAltPropDisplayManual)) {
      foreach ($locationAltPropDisplayManual as $propId => $switch) {
        if (intval($propId)) {
          $arResult['LOCATION_ALT_PROP_DISPLAY_MANUAL'][intval($propId)] = !!$switch;
        }
      }
    }

    $basket = $this->calculateBasket;

    $discounts = $this->order->getDiscount();

    $showPrices = $discounts->getShowPrices();

    $arResult['REAL_BASE_PRICE'] = 0.0;

    if (!empty($showPrices['BASKET'])) {
      foreach ($showPrices['BASKET'] as $basketCode => $data) {
        $basketItem = $this->calculateBasket->getItemByBasketCode($basketCode);

        if ($basketItem instanceof BasketItemBase) {
          $arResult['REAL_BASE_PRICE'] += $data['REAL_BASE_PRICE'] * $basketItem->getQuantity();
        }
      }
    }

    $arResult['REAL_BASE_PRICE_FORMATED'] = SaleFormatCurrency($arResult['REAL_BASE_PRICE'], $this->order->getCurrency());

    $applyResult = $discounts->getApplyResult();

    $arResult["DISCOUNTS"] = array();

    foreach($applyResult['DISCOUNT_LIST'] as $discount) {
      $sum = 0.0;

      foreach($applyResult['ORDER'] as $applyDiscount) {
        if ($applyDiscount['DISCOUNT_ID']!=$discount['ID'] || !is_array($applyDiscount['RESULT']['BASKET'])) {
          continue;
        }

        foreach($applyDiscount['RESULT']['BASKET'] as $applyDiscountResult) {
          if(!is_array($applyDiscountResult['DESCR_DATA'])) {
            continue;
          }

          $basketItem = $this->calculateBasket->getItemByBasketCode($applyDiscountResult['BASKET_ID']);

          if (!($basketItem instanceof BasketItemBase)) {
            continue;
          }

          foreach($applyDiscountResult['DESCR_DATA'] as $applyDiscountResultValue) {

            if ($applyDiscountResultValue['RESULT_UNIT']!=$this->order->getCurrency()) {
              continue;
            }

            $sum += $applyDiscountResultValue['RESULT_VALUE']*$basketItem->getQuantity();
          }
        }
      }

      if ($sum!=0) {
        $arResult["DISCOUNTS"][] = array(
          "NAME"=>$discount['NAME'],
          "SUM"=>$sum,
          "SUM_FORMATED"=>SaleFormatCurrency($sum, $this->order->getCurrency()),
        );
      }
    }

    $arResult['ORDER_PRICE'] = $basket->getPrice();
    $arResult['ORDER_PRICE_FORMATED'] = SaleFormatCurrency($arResult['ORDER_PRICE'], $this->order->getCurrency());
    $arResult['ORDER_WEIGHT'] = $basket->getWeight();
    $arResult['ORDER_WEIGHT_FORMATED'] = roundEx(floatval($arResult['ORDER_WEIGHT'] / $arResult['WEIGHT_KOEF']), SALE_WEIGHT_PRECISION).' '.$arResult['WEIGHT_UNIT'];
    $arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] = $basket->getBasePrice();
    $arResult['PRICE_WITHOUT_DISCOUNT'] = SaleFormatCurrency($arResult['PRICE_WITHOUT_DISCOUNT_VALUE'], $this->order->getCurrency());
    $arResult['DISCOUNT_PRICE'] = Sale\PriceMaths::roundPrecision(
      $this->order->getDiscountPrice() + ($arResult['PRICE_WITHOUT_DISCOUNT_VALUE'] - $arResult['ORDER_PRICE'])
    );
    $arResult['DISCOUNT_PRICE_FORMATED'] = SaleFormatCurrency($arResult['DISCOUNT_PRICE'], $this->order->getCurrency());
    $arResult['DELIVERY_PRICE'] = Sale\PriceMaths::roundPrecision($this->order->getDeliveryPrice());
    $arResult['DELIVERY_PRICE_FORMATED'] = SaleFormatCurrency($arResult['DELIVERY_PRICE'], $this->order->getCurrency());
    $arResult['ORDER_TOTAL_PRICE'] = Sale\PriceMaths::roundPrecision($this->order->getPrice());
    $arResult['ORDER_TOTAL_PRICE_FORMATED'] = SaleFormatCurrency($arResult['ORDER_TOTAL_PRICE'], $this->order->getCurrency());
  }

  public function getJsDataResult()
  {
    global $USER;

    $arResult =& $this->arResult;

    $result =& $this->arResult['JS_DATA'];

    parent::getJsDataResult();

    $result['TOTAL']['REAL_BASE_PRICE'] = $arResult['REAL_BASE_PRICE'];
    $result['TOTAL']['REAL_BASE_PRICE_FORMATED'] = $arResult['REAL_BASE_PRICE_FORMATED'];
    $result['TOTAL']['DISCOUNTS'] = $arResult['DISCOUNTS'];
  }
}
