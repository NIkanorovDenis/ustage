<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Приобрести подарочный сертификат номиналом 3 000, 5 000 и 10 000 рублей от компании USTAGE GROUP для покупки сценической и шоу-техники.");
$APPLICATION->SetPageProperty("title", "Подарочные карты от компании USTAGE GROUP для приобретения сценической и шоу-техники");
$APPLICATION->SetTitle("Лучший подарок – подарочные карты");

$_REQUEST['SECTION_CODE'] = 'svetofiltry';

?><div class="gift-cards">
	 <?$APPLICATION->IncludeComponent(
	"bxready.market2:catalog.bestsellers",
	".default",
	Array(
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"BESTSELLER_IBLOCK_ID" => "60",
		"BESTSELLER_IBLOCK_TYPE" => "content",
		"BXREADY_ELEMENT_ADDCLASS_LISTPAGE" => "",
		"BXREADY_ELEMENT_DRAW_LISTPAGE" => "ecommerce.m2.v1",
		"BXREADY_ELEMENT_EXT_PARAMS_LISTPAGE" => "arrExtParams",
		"BXREADY_LIST_BOOTSTRAP_GRID_STYLE" => "",
		"BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS_LISTPAGE" => "N",
		"BXREADY_LIST_HIDE_SLIDER_ARROWS_LISTPAGE" => "Y",
		"BXREADY_LIST_LG_CNT_LISTPAGE" => "4",
		"BXREADY_LIST_MARKER_TYPE_LISTPAGE" => "ribbon.vertical",
		"BXREADY_LIST_MD_CNT_LISTPAGE" => "6",
		"BXREADY_LIST_PAGE_BLOCK_TITLE" => "",
		"BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON" => "",
		"BXREADY_LIST_SLIDER_AUTOSCROLL_LISTPAGE" => "N",
		"BXREADY_LIST_SLIDER_LISTPAGE" => "Y",
		"BXREADY_LIST_SLIDER_MARKERS_LISTPAGE" => "Y",
		"BXREADY_LIST_SM_CNT_LISTPAGE" => "6",
		"BXREADY_LIST_VERTICAL_SLIDER_MODE_LISTPAGE" => "N",
		"BXREADY_LIST_XLG_CNT_LISTPAGE" => "3",
		"BXREADY_LIST_XS_CNT_LISTPAGE" => "12",
		"BXREADY_USER_TYPES_LISTPAGE" => "N",
		"BXREADY_USE_ELEMENTCLASS_LISTPAGE" => "Y",
		"BXREADY_VERTICAL_ALIGN_LISTPAGE" => "Y",
		"BXR_SHOW_ACTION_TIMER_LISTPAGE" => "DARK",
		"BXR_SHOW_ARTICLE_LISTPAGE" => "Y",
		"BXR_SHOW_RATING_LISTPAGE" => "N",
		"BXR_SHOW_SLIDER_LISTPAGE" => "Y",
		"BXR_SKU_PROPS_SHOW_TYPE_LISTPAGE" => "rounded",
		"BXR_SLIDER_INTERVAL_LISTPAGE" => "3000",
		"BXR_TILE_SHOW_PROPERTIES_LISTPAGE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"CONVERT_CURRENCY" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "32",
		"IBLOCK_TYPE" => "catalog_new",
		"OFFERS_PROPERTY_CODE" => array(0=>"SILENT",1=>"SIZE",2=>"COLOR",),
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "10",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(0=>"BASE",1=>"OPT",),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(0=>"MATERIAL",1=>"SPECIALOFFER",2=>"SUVENIR_NAZNACH",3=>"NEWPRODUCT",4=>"GLASS_OS",5=>"BXR_RELATED",6=>"PAL_TYPE",7=>"VELO_TYPE",8=>"SALELEADER",9=>"RECOMMENDED",10=>"PLATFORM",11=>"COMPLECT",12=>"ARB_TIME",13=>"GLASS_TYPE",14=>"DISPLAY_TYPE",15=>"GLASS_ALL",16=>"OBJOM_VSTROENNOY_PAMYATI",17=>"SIZE_ACCUMUL",18=>"FORM_FACTOR",19=>"DYSPLAY_CAM",20=>"ACCESSORIES",21=>"BXR_VIDEO",22=>"CML2_ATTRIBUTES",23=>"CML2_TRAITS",24=>"CML2_TAXES",25=>"SKU_TYPE",26=>"BXR_DISCOUNT_TIMER",),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"SHOW_PRICE_COUNT" => "1",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);?>
</div>
 <b>Правила использования:</b><br>
 <br>
<ol>
	<li>Подарочный сертификат (карта) — документ, удостоверяющий право его предъявителя на&nbsp;приобретение товаров в&nbsp;пределах номинала Подарочного сертификата.</li>
	<li>Покупатель Подарочного сертификата&nbsp;— физическое или юридическое лицо, получившее Подарочный сертификат в&nbsp;подтверждение факта заключения им&nbsp;договора в&nbsp;пользу третьего лица (Предъявителя Подарочного сертификата), и&nbsp;оплатившее стоимость подарочного сертификата, равной номинальной стоимости, в&nbsp;счет оплаты товара, который будет приобретен Предъявителем Подарочного сертификата.</li>
	<li>Предъявитель Подарочного сертификата&nbsp;— любое физическое лицо, владеющее указанным сертификатом на&nbsp;законном основании (на&nbsp;основании договора, заключенного в&nbsp;письменной или устной форме с&nbsp;Покупателем Подарочного сертификата), предъявивший Подарочный сертификат продавцу ООО «Юстейдж» при приобретении товаров.</li>
	<li>Подарочный сертификат может быть использован Предъявителем однократно. При совершении покупки номинал Подарочного сертификата списывается полностью. С&nbsp;момента использования Подарочного сертификата его действие прекращается. Подарочный сертификат не&nbsp;может быть использован для получения денежных средств.</li>
	<li>Подарочный сертификат не&nbsp;подлежит возврату.</li>
	<li>Срок действия подарочного сертификата составляет 1&nbsp;год с&nbsp;момента продажи. По&nbsp;истечении указанного срока неиспользованный Подарочный сертификат аннулируется. Денежные средства по&nbsp;аннулированным Подарочным сертификатам не&nbsp;возвращаются.</li>
	<li>В&nbsp;случае, если стоимость товара, приобретаемого Предъявителем с&nbsp;использованием Подарочного сертификата, меньше ее&nbsp;номинальной стоимости, разница между стоимостью товара и&nbsp;номиналом Подарочного сертификата не&nbsp;выплачивается.</li>
	<li>В&nbsp;случае, если стоимость товара, приобретаемого Предъявителем с&nbsp;использованием Подарочного сертификата, больше его номинальной стоимости, Предъявитель оплачивает разницу между стоимостью товара и&nbsp;номиналом Подарочного сертификата путем наличной или безналичной оплаты (расчета). Суммирование нескольких Подарочных сертификатов в&nbsp;одном чеке допускается.</li>
	<li>Сертификат действует только на&nbsp;товар (оплатить доставку сертификатом нельзя).</li>
	<li>Воспользоваться подарочным сертификат можно, предъявив сертификат при покупке в&nbsp;магазине, либо указав номер сертификата в&nbsp;специальной графе при оформлении онлайн-заказа.</li>
	<li>В&nbsp;случае утраты сертификат не&nbsp;восстанавливается.</li>
	<li>При использовании подарочный сертификат изымается.</li>
</ol>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>