<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

$buttons = \Bitrix\Landing\Hook\Page\B24button::getButtons();
$buttons = array_keys($buttons);

return array(
        'code' => 'car-repair-shop',
	'name' => Loc::getMessage('LANDING_DEMO_BXREADY24_CAR_REPAIR_SHOP_TITLE'),
	'description' => Loc::getMessage('LANDING_DEMO_BXREADY24_CAR_REPAIR_SHOP_DESCRIPTION'),
        'preview' => 'https://cdn.bxready.ru/pictures/bxready24_template/9c1d4cde59420a7b898acf076abe5962.jpg',
	'fields' => 
                array (
                    'ADDITIONAL_FIELDS' => 
                        array (
                            'B24BUTTON_COLOR' => $buttons[0],
                            'THEME_CODE' => 'photography',
                            'THEME_CODE_TYPO' => 'photography',
                            'UP_SHOW' => 'N',
                            'VIEW_USE' => 'N',
                            'VIEW_TYPE' => 'no',
    
                        ),
                    'TITLE' => Loc::getMessage('LANDING_DEMO_BXREADY24_CAR_REPAIR_SHOP_TITLE'),
                    'LANDING_ID_INDEX' => 'bxready24/car-repair-shop',
                  ),
        'layout' => array(),
        'folders' => array(),
	'sort' => -112,
	'available' => true,
	'active' => \LandingSiteDemoComponent::checkActive(array(
		'ONLY_IN' => array('ru'),
		'EXCEPT' => array()
	))
);