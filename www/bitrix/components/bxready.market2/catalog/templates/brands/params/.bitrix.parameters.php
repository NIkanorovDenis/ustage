<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Web\Json;

$lineElementCount = (int)$arCurrentValues['LINE_ELEMENT_COUNT'] ?: 3;
$pageElementCount = (int)$arCurrentValues['PAGE_ELEMENT_COUNT'] ?: 18;

$variants = CatalogSectionComponent::getTemplateVariantsMap();
$defaultVariants = CatalogSectionComponent::predictRowVariants($lineElementCount, $pageElementCount);

unset($variants[9]);
unset($defaultVariants[9]);

$arTemplateParameters['PRODUCT_ROW_VARIANTS'] = array(
	'PARENT' => 'BXR_BITRIX_LIST_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_PRODUCT_ROW_VARIANTS'),
	'TYPE' => 'CUSTOM',
	'BIG_DATA' => 'Y',
	'COUNT_PARAM_NAME' => 'PAGE_ELEMENT_COUNT',
	'JS_FILE' => CatalogSectionComponent::getSettingsScript('/bitrix/components/bxready.market2/catalog.section', 'dragdrop_add'),
	'JS_EVENT' => 'initDraggableAddControl',
	'JS_MESSAGES' => Json::encode(array(
            'variant' => GetMessage('CP_BCS_TPL_SETTINGS_VARIANT'),
            'delete' => GetMessage('CP_BCS_TPL_SETTINGS_DELETE'),
            'quantity' => GetMessage('CP_BCS_TPL_SETTINGS_QUANTITY'),
            'quantityBigData' => GetMessage('CP_BCS_TPL_SETTINGS_QUANTITY_BIG_DATA')
        )),
	'JS_DATA' => Json::encode($variants),
	'DEFAULT' => Json::encode($defaultVariants)
);

global $arComponentGroups, $arReload;

$allSettings = array(
        'standart' => array(
            'settings' => array(
                'type' => 'ecommerce',
                'sort' => 1012,
                'collection' => array(
                    'ecommerce.m2.v1',
                    'ecommerce.m2.managed.v1'
                )
            ),
            'addContext' => 'STANDART',
            'addTitle' => GetMessage('BXR_LIST_TYPE_BX').' Standart'
        ),
        'big' => array(
            'settings' => array(
                'type' => 'ecommerce',
                'sort' => 1020,
                'collection' => array(
                    'ecommerce.m2.big.v1',
                    'ecommerce.m2.v1'
                )
            ),
            'addContext' => 'BIG',
            'addTitle' => GetMessage('BXR_LIST_TYPE_BX').' Big'
        )
);

foreach ($allSettings as $cell=>$val) {
    $additionalParams = \Alexkova\Bxready2\Component::getPresents(
        $arCurrentValues,
        $val['settings'],
        $val['addContext'],
        $val['addTitle']
    );

    if (is_array($additionalParams)) {
        if (count($additionalParams['LIST_GROUPS'])>0) {
            foreach ($additionalParams['LIST_GROUPS'] as $cell=>$val) {
                $arComponentGroups[$cell] = $val;
            }
        }

        if (count($additionalParams['LIST_PARAMS'])>0) {
            foreach ($additionalParams['LIST_PARAMS'] as $cell=>$val) {
                $arTemplateParameters[$cell] = $val;
            }
        }
    }
}