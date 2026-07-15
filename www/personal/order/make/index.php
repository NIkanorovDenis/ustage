<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>

<?
$arMinOrderPrice = $APPLICATION->IncludeComponent(
    "bxready.market2:order.min.price",
    ".default",
    array(),
    false
);
?>
<?if ($arMinOrderPrice["ADD_PRICE"] <= 0 || $_REQUEST["ORDER_ID"]) {?>
    <?$APPLICATION->IncludeComponent("visualteam:sale.order.ajax", "order_ajax", Array(
	"PAY_FROM_ACCOUNT" => "N",	// Разрешить оплату с внутреннего счета
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",	// Разрешить оплату с внутреннего счета только в полном объеме
		"ALLOW_AUTO_REGISTER" => "Y",	// Оформлять заказ с автоматической регистрацией пользователя
		"SEND_NEW_USER_NOTIFY" => "Y",	// Отправлять пользователю письмо, что он зарегистрирован на сайте
		"DELIVERY_NO_AJAX" => "N",	// Когда рассчитывать доставки с внешними системами расчета
		"TEMPLATE_LOCATION" => "popup",	// Визуальный вид контрола выбора местоположений
		"PROP_1" => "",
		"PATH_TO_BASKET" => SITE_DIR."personal/basket/",	// Путь к странице корзины
		"PATH_TO_PERSONAL" => SITE_DIR."personal/orders/",	// Путь к странице персонального раздела
		"PATH_TO_PAYMENT" => SITE_DIR."personal/order/payment/",	// Страница подключения платежной системы
		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"DELIVERY2PAY_SYSTEM" => "",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"DELIVERY_NO_SESSION" => "Y",	// Проверять сессию при оформлении заказа
		"COMPONENT_TEMPLATE" => ".default",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",	// Последовательность оформления
		"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
		"ALLOW_NEW_PROFILE" => "N",	// Разрешить множество профилей покупателей
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",	// Показывать изображения складов в окне выбора пункта выдачи
		"PATH_TO_AUTH" => SITE_DIR."auth/",	// Путь к странице авторизации
		"DISABLE_BASKET_REDIRECT" => "N",	// Оставаться на странице оформления заказа, если список товаров пуст
		"PRODUCT_COLUMNS" => "",
		"ALLOW_APPEND_ORDER" => "Y",	// Разрешить оформлять заказ на существующего пользователя
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",	// Отображение доставок с ошибками расчета
		"SPOT_LOCATION_BY_GEOIP" => "Y",	// Определять местоположение покупателя по IP-адресу
		"SHOW_VAT_PRICE" => "Y",	// Отображать значение НДС
		"COMPATIBLE_MODE" => "Y",	// Режим совместимости для предыдущего шаблона
		"USE_PRELOAD" => "Y",	// Автозаполнение оплаты и доставки по предыдущему заказу
		"ALLOW_USER_PROFILES" => "N",	// Разрешить использование профилей покупателей
		"TEMPLATE_THEME" => "site",	// Цветовая тема
		"SHOW_ORDER_BUTTON" => "final_step",	// Отображать кнопку оформления заказа (для неавторизованных пользователей)
		"SHOW_TOTAL_ORDER_BUTTON" => "N",	// Отображать дополнительную кнопку оформления заказа
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",	// Отображать названия в списке платежных систем
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",	// Отображать название в блоке информации по платежной системе
		"SHOW_DELIVERY_LIST_NAMES" => "Y",	// Отображать названия в списке доставок
		"SHOW_DELIVERY_INFO_NAME" => "Y",	// Отображать название в блоке информации по доставке
		"SHOW_DELIVERY_PARENT_NAMES" => "N",	// Показывать название родительской доставки
		"SKIP_USELESS_BLOCK" => "Y",	// Пропускать шаги, в которых один элемент для выбора
		"BASKET_POSITION" => "before",	// Расположение списка товаров
		"SHOW_BASKET_HEADERS" => "N",	// Показывать заголовки колонок списка товаров
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",	// Дополнительные услуги, которые будут показаны в пройденном (свернутом) блоке
		"SHOW_COUPONS_BASKET" => "N",	// Показывать поле ввода купонов в блоке списка товаров
		"SHOW_COUPONS_DELIVERY" => "N",	// Показывать поле ввода купонов в блоке доставки
		"SHOW_COUPONS_PAY_SYSTEM" => "N",	// Показывать поле ввода купонов в блоке оплаты
		"SHOW_NEAREST_PICKUP" => "N",	// Показывать ближайшие пункты самовывоза
		"DELIVERIES_PER_PAGE" => "9",	// Количество доставок на странице
		"PAY_SYSTEMS_PER_PAGE" => "9",	// Количество платежных систем на странице
		"PICKUPS_PER_PAGE" => "5",	// Количество пунктов самовывоза на странице
		"SHOW_PICKUP_MAP" => "Y",	// Показывать карту для доставок с самовывозом
		"SHOW_MAP_IN_PROPS" => "N",	// Показывать карту в блоке свойств заказа
		"PICKUP_MAP_TYPE" => "yandex",	// Тип используемых карт
		"PROPS_FADE_LIST_1" => array(	// Свойства заказа, которые будут показаны в пройденном (свернутом) блоке (Физическое лицо)[s1]
			0 => "1",
			1 => "2",
			2 => "3",
			3 => "7",
		),
		"PROPS_FADE_LIST_2" => array(	// Свойства заказа, которые будут показаны в пройденном (свернутом) блоке (Юридическое лицо)[s1]
			0 => "8",
			1 => "10",
			2 => "11",
			3 => "12",
			4 => "13",
			5 => "14",
			6 => "19",
		),
		"USER_CONSENT" => "Y",	// Запрашивать согласие
		"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"PRODUCT_COLUMNS_VISIBLE" => array(	// Выбранные колонки таблицы списка товаров
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
			2 => "PROPERTY_COLOR",
			3 => "PROPERTY_SIZE",
			4 => "PROPERTY_PICTURES_SKU",
		),
		"ADDITIONAL_PICT_PROP_12" => "-",
		"ADDITIONAL_PICT_PROP_13" => "-",
		"BASKET_IMAGES_SCALING" => "adaptive",	// Режим отображения изображений товаров
		"SERVICES_IMAGES_SCALING" => "adaptive",	// Режим отображения вспомагательных изображений
		"PRODUCT_COLUMNS_HIDDEN" => array(	// Свойства товаров отображаемые в свернутом виде в списке товаров
			0 => "PROPERTY_PICTURES_SKU",
		),
		"USE_YM_GOALS" => "N",	// Использовать цели счетчика Яндекс.Метрики
		"USE_ENHANCED_ECOMMERCE" => "Y",	// Отправлять данные электронной торговли в Google и Яндекс
		"USE_CUSTOM_MAIN_MESSAGES" => "Y",	// Заменить стандартные фразы на свои
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "Y",	// Заменить стандартные фразы на свои
		"USE_CUSTOM_ERROR_MESSAGES" => "Y",	// Заменить стандартные фразы на свои
		"USER_CONSENT_ID" => "1",	// Соглашение
		"USER_CONSENT_IS_CHECKED" => "Y",	// Галка по умолчанию проставлена
		"USER_CONSENT_IS_LOADED" => "N",	// Загружать текст сразу
		"EMPTY_BASKET_HINT_PATH" => "/",	// Путь к странице для продолжения покупок
		"USE_PHONE_NORMALIZATION" => "Y",	// Использовать нормализацию номера телефона
		"ADDITIONAL_PICT_PROP_17" => "-",
		"ADDITIONAL_PICT_PROP_18" => "-",
		"ADDITIONAL_PICT_PROP_32" => "-",	// Дополнительная картинка [Товары]
		"ADDITIONAL_PICT_PROP_33" => "-",	// Дополнительная картинка [Предложения]
		"HIDE_ORDER_DESCRIPTION" => "N",	// Скрыть поле комментариев к заказу
		"MESS_AUTH_BLOCK_NAME" => "Авторизация",	// Название блока авторизации
		"MESS_REG_BLOCK_NAME" => "Регистрация",	// Название блока регистрации
		"MESS_BASKET_BLOCK_NAME" => "Товары в заказе",	// Название блока списка товаров
		"MESS_REGION_BLOCK_NAME" => "Плательщик",	// Название блока региона доставки
		"MESS_PAYMENT_BLOCK_NAME" => "Оплата",	// Название блока оплаты
		"MESS_DELIVERY_BLOCK_NAME" => "Способ получения",	// Название блока доставки
		"MESS_BUYER_BLOCK_NAME" => "Покупатель",	// Название блока свойств заказа
		"MESS_BACK" => "Предыдущий шаг",	// Кнопка возврата к предыдущему блоку
		"MESS_FURTHER" => "Следующий шаг",	// Кнопка перехода к следующему блоку
		"MESS_EDIT" => "Редактировать информацию",	// Кнопка редактирования блока
		"MESS_ORDER" => "Оформить заказ",	// Кнопка оформления заказа
		"MESS_PRICE" => "Стоимость",	// Заголовок для цены
		"MESS_PERIOD" => "Срок доставки",	// Заголовок для срока доставки
		"MESS_NAV_BACK" => "Назад",	// Кнопка перехода к предыдущей странице
		"MESS_NAV_FORWARD" => "Вперед",	// Кнопка перехода к следующей странице
		"MESS_PRICE_FREE" => "бесплатно",	// Текст для "бесплатно"
		"MESS_ECONOMY" => "Экономия",	// Текст для "Экономия"
		"MESS_REGISTRATION_REFERENCE" => "Если вы впервые на сайте, и хотите, чтобы мы вас помнили и все ваши заказы сохранялись, заполните регистрационную форму.",	// Текст для перехода к блоку регистрации
		"MESS_AUTH_REFERENCE_1" => "Символом \"звездочка\" (*) отмечены обязательные для заполнения поля.",	// Справочная информация №1 блока "Авторизация"
		"MESS_AUTH_REFERENCE_2" => "После регистрации вы получите информационное письмо.",	// Справочная информация №2 блока "Авторизация"
		"MESS_AUTH_REFERENCE_3" => "Личные сведения, полученные в распоряжение интернет-магазина при регистрации или каким-либо иным образом, не будут без разрешения пользователей передаваться третьим организациям и лицам за исключением ситуаций, когда этого требует закон или судебное решение.",	// Справочная информация №3 блока "Авторизация"
		"MESS_ADDITIONAL_PROPS" => "Дополнительные свойства",	// Кнопка дополнительных свойств товара
		"MESS_USE_COUPON" => "Применить купон",	// Заголовок поля ввода купона
		"MESS_COUPON" => "Купон",	// Заголовок для примененных купонов
		"MESS_PERSON_TYPE" => "Плательщик",	// Заголовок выбора типа плательщика
		"MESS_SELECT_PROFILE" => "Выберите профиль",	// Заголовок выбора профиля
		"MESS_REGION_REFERENCE" => "Выберите свой город в списке. Если вы не нашли свой город, выберите \"другое местоположение\", а город впишите в поле \"Город\"",	// Справочная информация блока "Регион"
		"MESS_PICKUP_LIST" => "Пункты самовывоза:",	// Заголовок пунктов самовывоза
		"MESS_NEAREST_PICKUP_LIST" => "Ближайшие пункты:",	// Заголовок ближайших пунктов самовывоза
		"MESS_SELECT_PICKUP" => "Выбрать",	// Кнопка выбора пункта самовывоза
		"MESS_INNER_PS_BALANCE" => "На вашем пользовательском счете:",	// Информация о балансе внутреннего счета
		"MESS_ORDER_DESC" => "Комментарии к заказу (необязательно):",	// Заголовок комментариев к заказу
		"MESS_SUCCESS_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически.Если все заполнено верно, нажмите кнопку \"#ORDER_BUTTON#\".",	// Текст уведомления о корректной загрузке данных заказа
		"MESS_FAIL_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически. Обратите внимание на развернутый блок с информацией о заказе. Здесь вы можете внести необходимые изменения или оставить как есть и нажать кнопку \"#ORDER_BUTTON#\".",	// Текст уведомления о неудачной загрузке данных заказа
		"MESS_DELIVERY_CALC_ERROR_TITLE" => "Не удалось рассчитать стоимость доставки.",	// Заголовок ошибки расчета доставки
		"MESS_DELIVERY_CALC_ERROR_TEXT" => "Вы можете продолжить оформление заказа, а чуть позже менеджер магазина свяжется с вами и уточнит информацию по доставке.",	// Текст ошибки расчета доставки
		"MESS_PAY_SYSTEM_PAYABLE_ERROR" => "Вы сможете оплатить заказ после того, как менеджер проверит наличие полного комплекта товаров на складе. Сразу после проверки вы получите письмо с инструкциями по оплате. Оплатить заказ можно будет в персональном разделе сайта.",	// Текст уведомления при статусе заказа, недоступном для оплаты
		"ADDITIONAL_PICT_PROP_35" => "-",	// Дополнительная картинка [Каталог товаров]
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"SHOW_COUPONS" => "Y",	// Отображать поля ввода купонов
		"ADDITIONAL_PICT_PROP_54" => "-",	// Дополнительная картинка [Каталог товаров (предложения)]
		"DATA_LAYER_NAME" => "dataLayer",	// Имя контейнера данных
		"BRAND_PROPERTY" => "PROPERTY_MANUFACTURER",	// Свойство, в котором указан бренд товара
		"YM_GOALS_COUNTER" => "80012047",
		"YM_GOALS_INITIALIZE" => "BX-order-init",
		"YM_GOALS_EDIT_REGION" => "BX-region-edit",
		"YM_GOALS_EDIT_DELIVERY" => "BX-delivery-edit",
		"YM_GOALS_EDIT_PICKUP" => "BX-pickUp-edit",
		"YM_GOALS_EDIT_PAY_SYSTEM" => "BX-paySystem-edit",
		"YM_GOALS_EDIT_PROPERTIES" => "BX-properties-edit",
		"YM_GOALS_EDIT_BASKET" => "BX-basket-edit",
		"YM_GOALS_NEXT_REGION" => "BX-region-next",
		"YM_GOALS_NEXT_DELIVERY" => "BX-delivery-next",
		"YM_GOALS_NEXT_PICKUP" => "BX-pickUp-next",
		"YM_GOALS_NEXT_PAY_SYSTEM" => "BX-paySystem-next",
		"YM_GOALS_NEXT_PROPERTIES" => "BX-properties-next",
		"YM_GOALS_NEXT_BASKET" => "BX-basket-next",
		"YM_GOALS_SAVE_ORDER" => "BX-order-save"
	),
	false
);?>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
