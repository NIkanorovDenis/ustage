<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$allSettings = array(
    'present_list' => array(
        'settings' => array(
            'type' => 'ecommerce',
            'sort' => 1030,
            'collection' => array(
                'ecommerce.m2.list.v1',
                'ecommerce.m2.list.v2'
            )
        ),
        'addContext' => 'PRESENT_LIST',
        'addTitle' => GetMessage('BXR_PRESENT_SETTINGS_LIST')
    )
);

foreach ($allSettings as $cell => $val){
    $additionalParams = \Alexkova\Bxready2\Component::getPresents(
        $arCurrentValues,
        $val['settings'],
        $val['addContext'],
        $val['addTitle']
    );

    if (is_array($additionalParams)) {
        if (count($additionalParams['LIST_GROUPS'])>0) {
            foreach ($additionalParams['LIST_GROUPS'] as $cell => $val) {
                $arComponentGroups[$cell] = $val;
            }
        }

        if (count($additionalParams['LIST_PARAMS'])>0) {
            foreach ($additionalParams['LIST_PARAMS'] as $cell => $val) {
                $arTemplateParameters[$cell] = $val;
            }
        }
    }
}