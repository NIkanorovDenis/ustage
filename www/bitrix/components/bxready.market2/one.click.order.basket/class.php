<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)   die();?>

<?
class OneClickOrder
{
    static $MODULE_ID = 'alexkova.market2';
    static $default_order_page = "/personal/order/success/";

    public static function getPropertyByCode($propertyCollection, $code)  {
        foreach ($propertyCollection as $property)
        {
            if($property->getField('CODE') == $code)
                return $property;
        }

        return false;
    }

    public static function makeOrder($params) {
        global $USER;
        $orderId = false;
        $error = false;

        $bxr_one_click_order_basket = \COption::GetOptionString(self::$MODULE_ID, "bxr_one_click_order_basket", "N");
        if ($bxr_one_click_order_basket == 'Y'
            && \CModule::IncludeModule('sale') && \CModule::IncludeModule('catalog')) {
            $bxr_order_user_basket = \COption::GetOptionString(self::$MODULE_ID, "bxr_order_user_basket");
            $bxr_order_status_basket = \COption::GetOptionString(self::$MODULE_ID, "bxr_order_status_basket");
            $bxr_order_person_type_basket = \COption::GetOptionString(self::$MODULE_ID, "bxr_order_person_type_basket");
            $bxr_order_user_name_basket = \COption::GetOptionString(self::$MODULE_ID, "bxr_order_user_name_basket");
            $bxr_order_user_phone_basket = \COption::GetOptionString(self::$MODULE_ID, "bxr_order_user_phone_basket");
            $bxr_order_user_email_basket = \COption::GetOptionString(self::$MODULE_ID, "bxr_order_user_email_basket");

            $bxr_order_user_basket = ($USER->IsAuthorized()) ? $USER->GetId() : $bxr_order_user_basket;

            if (intval($bxr_order_user_basket) > 0 && strlen($bxr_order_status_basket) > 0 && intval($bxr_order_person_type_basket) > 0) {
                $arOrderParams = array(
                    'USER_ID' => $bxr_order_user_basket,
                    'USER_NAME' => $bxr_order_user_name_basket,
                    'USER_PHONE' => $bxr_order_user_phone_basket,
                    'USER_EMAIL' => $bxr_order_user_email_basket,
                    'STATUS' => $bxr_order_status_basket,
                    'PERSON_TYPE_ID' => $bxr_order_person_type_basket,
                    'SITE_ID' => \Bitrix\Main\Context::getCurrent()->getSite()
                );

                $userName = $params['USER_NAME'];
                $userPhone = $params['USER_PHONE'];
                $userEmail = $params['USER_EMAIL'];
                $userComment = $params['USER_COMMENT'];

                $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $arOrderParams['SITE_ID'])->getOrderableItems();
				$basket_item_quantity = $basket->getQuantityList();

				if ($basket_item_quantity) {
					\Bitrix\Sale\DiscountCouponsManager::init();

					$order = \Bitrix\Sale\Order::create($arOrderParams['SITE_ID'], $arOrderParams['USER_ID']);
					$order->setPersonTypeId($arOrderParams['PERSON_TYPE_ID']);
					$order->setField('STATUS_ID', $arOrderParams['STATUS']);
					$order->setBasket($basket);

					$order->doFinalAction(true);

					$propertyCollection = $order->getPropertyCollection();

					if ($userName && strlen($arOrderParams["USER_NAME"]) > 0) {
                        $nameProperty = self::getPropertyByCode($propertyCollection, 'FIO');
						if ($nameProperty) {
							$nameProperty->setValue($userName);
                        }
                        $nameProperty = self::getPropertyByCode($propertyCollection, $arOrderParams["USER_NAME"]);
                        if ($nameProperty) {
                            $nameProperty->setValue($userName);
                        }
					}
					if ($userPhone && strlen($arOrderParams["USER_PHONE"]) > 0) {
						$phoneProperty = self::getPropertyByCode($propertyCollection, 'PHONE');
                        if ($phoneProperty) {
                            $phoneProperty->setValue($userPhone);
                        }
                        $phoneProperty = self::getPropertyByCode($propertyCollection, $arOrderParams["USER_PHONE"]);
                        if ($phoneProperty) {
                            $phoneProperty->setValue($userPhone);
                        }
					}
					if ($userEmail && strlen($arOrderParams["USER_EMAIL"]) > 0) {
						$emailProperty = self::getPropertyByCode($propertyCollection, 'EMAIL');
                        if ($emailProperty) {
                            $emailProperty->setValue($userEmail);
                        }
                        $emailProperty = self::getPropertyByCode($propertyCollection, $arOrderParams["USER_EMAIL"]);
						if ($emailProperty) {
							$emailProperty->setValue($userEmail);
                        }
					}
					if ($userComment)
						$order->setField('USER_DESCRIPTION', $userComment);

                    /*$coll = '';
                    foreach ($propertyCollection as $property) {
                        $coll .= '|'.$property->getField('CODE');
                    }*/
                    //return '/personal/order/success/?error='.$coll;

					$result = $order->save();

					$orderId = $order->GetId();
				}
            } else {
                if (intval($bxr_order_user_basket) <= 0)
                    $error = 'BASKET USER UNDEFINED';
                if (strlen($bxr_order_status_basket) <= 0)
                    $error = 'ORDER STATUS UNDEFINED';
                if (intval($bxr_order_person_type_basket) <= 0)
                    $error = 'ORDER PERSON TYPE UNDEFINED';
            }
        } else {
            if ($bxr_one_click_order_basket != 'Y')
                $error = 'ONE_CLICK_DISABLED';
            if (!\CModule::IncludeModule('sale'))
                $error = 'SALE MODULE NOT INSTALLED';
            if (!\CModule::IncludeModule('catalog'))
                $error = 'CATALOG MODULE NOT INSTALLED';
        }

        $bxr_order_success_basket = COption::GetOptionString(self::$MODULE_ID, "bxr_order_success_basket", "/personal/order/success/");
        if (!$bxr_order_success_basket)
            $bxr_order_success_basket = self::$default_order_page;

        if (!$orderId)
            $error = 'ORDER CREATE ERROR';
        else
            $bxr_order_success_basket .= "?orderId=".$orderId;

        if ($error)
            $bxr_order_success_basket .= "?error=".$error;

        return $bxr_order_success_basket;
    }
}