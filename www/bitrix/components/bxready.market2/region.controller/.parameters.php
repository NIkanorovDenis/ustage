<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
use Bitrix\Main\Loader;
use Bitrix\Iblock;

if (!Loader::includeModule('iblock'))
	return;
$catalogIncluded = Loader::includeModule('catalog');
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$iblockFilter = (
	!empty($arCurrentValues['IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);
$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
unset($arr, $rsIBlock, $iblockFilter);

$arProperty = array();
if ($iblockExists)
{
    $propertyIterator = Iblock\PropertyTable::getList(array(
            'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE'),
            'filter' => array('=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=ACTIVE' => 'Y'),
            'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
    ));
    while ($property = $propertyIterator->fetch())
    {
            $propertyCode = (string)$property['CODE'];
            if ($propertyCode == '')
                    $propertyCode = $property['ID'];
            $propertyName = '['.$propertyCode.'] '.$property['NAME'];

            if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
                $arProperty[$propertyCode] = $propertyName;
    }
    unset($propertyCode, $propertyName, $property, $propertyIterator);
}
$arProperty_LNS = $arProperty;

$arAccuracy = array(
    'city' => GetMessage("CITY"),
    'region' => GetMessage("REGION"),
    'district' => GetMessage("DISTRICT")
);

$arComponentParameters = array(
	"GROUPS" => array(
		
	),
	"PARAMETERS" => array(
		
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_IBLOCK"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),

		"REGION_PROPERTIES" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("REGION_PROPERTIES"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty
		),

		"CACHE_TIME" => array(
			"DEFAULT" => 36000000,
		),
		
	),
);
?>