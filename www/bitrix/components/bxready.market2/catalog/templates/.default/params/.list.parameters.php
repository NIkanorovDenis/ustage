<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arTemplateParameters['BXR_EXT_LIST_SETTINGS_MODE'] = array(
	'PARENT' => 'BXR_EXT_LIST_SETTINGS',
	'NAME' => GetMessage('BXR_EXT_LIST_SETTINGS_ALL'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => "Y",
	'REFRESH' => 'Y'
);

if (!isset($arCurrentValues['BXR_EXT_LIST_SETTINGS_MODE']))
	$arCurrentValues['BXR_EXT_LIST_SETTINGS_MODE'] = 'Y';


$allSettings = array(
	'OTHER' => array(
		'settings' => array(
			'type'=>'ecommerce',
			'collection'=>array(
				'ecommerce.m2.big.v1',
				'ecommerce.m2.v1'
			),
			'sort'=>950
		),
		'addContext' => 'OTHER',
		'addTitle' => GetMessage('BCT')
	)
);

$addSettings = array(
	'bigdata' => array(
		'settings' => array(
			'type'=>'ecommerce',
			'sort'=>1491,
			'collection'=>array(
                            'ecommerce.m2.v1',
			),
                        'slider' => true,
		),
		'addContext' => 'BIGDATA',
		'addTitle' => 'BigData '
	),
	'saleleader' => array(
		'settings' => array(
			'type'=>'ecommerce',
			'collection'=>array(
				'ecommerce.m2.v1'
			),
                        'slider' => true,
			'sort'=>960
		),
		'addContext' => 'SALELEADER',
		'addTitle' => GetMessage('SALELEADER')
	),
	'viewed' => array(
		'settings' => array(
			'type'=>'ecommerce',
			'collection'=>array(
				'ecommerce.m2.v1'
			),
                        'slider' => true,
			'sort'=>970
		),
		'addContext' => 'VIEWED',
		'addTitle' => GetMessage('VIEWED')
	),
	'recommended' => array(
		'settings' => array(
			'type'=>'ecommerce',
			'collection'=>array(
				'ecommerce.m2.v1'
			),
			'sort'=>980
		),
		'addContext' => 'RECOMMENDED',
		'addTitle' => GetMessage('RECOMMENDED')
	),

	'search' => array(
		'settings' => array(
			'type'=>'ecommerce',
			'collection'=>array(
				'ecommerce.m2.v1'
			),
			'sort'=>1496
		),
		'addContext' => 'SEARCH',
		'addTitle' => GetMessage('SEARCH')
	)
);

if (isset($arCurrentValues['BXR_EXT_LIST_SETTINGS_MODE']) && $arCurrentValues['BXR_EXT_LIST_SETTINGS_MODE'] == "N"){

	$arTemplateParameters['BXR_EXT_LIST_SETTINGS_BIGDATA'] = array(
		'PARENT' => 'BXR_EXT_LIST_SETTINGS',
		'NAME' => GetMessage('BXR_EXT_LIST_SETTINGS_BIGDATA'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => "N",
		'REFRESH' => 'Y'
	);

	$arTemplateParameters['BXR_EXT_LIST_SETTINGS_SALELEADER'] = array(
		'PARENT' => 'BXR_EXT_LIST_SETTINGS',
		'NAME' => GetMessage('BXR_EXT_LIST_SETTINGS_SALELEADER'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => "N",
		'REFRESH' => 'Y'
	);

	$arTemplateParameters['BXR_EXT_LIST_SETTINGS_VIEWED'] = array(
		'PARENT' => 'BXR_EXT_LIST_SETTINGS',
		'NAME' => GetMessage('BXR_EXT_LIST_SETTINGS_VIEWED'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => "N",
		'REFRESH' => 'Y'
	);

	$arTemplateParameters['BXR_EXT_LIST_SETTINGS_RECOMMENDED'] = array(
		'PARENT' => 'BXR_EXT_LIST_SETTINGS',
		'NAME' => GetMessage('BXR_EXT_LIST_SETTINGS_RECOMMENDED'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => "N",
		'REFRESH' => 'Y'
	);

	$arTemplateParameters['BXR_EXT_LIST_SETTINGS_SEARCH'] = array(
		'PARENT' => 'BXR_EXT_LIST_SETTINGS',
		'NAME' => GetMessage('BXR_EXT_LIST_SETTINGS_SEARCH'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => "N",
		'REFRESH' => 'Y'
	);

    if (isset($arCurrentValues['BXR_EXT_LIST_SETTINGS_BIGDATA'])
        && $arCurrentValues['BXR_EXT_LIST_SETTINGS_BIGDATA'] == "Y"){
        $allSettings['bigdata'] = $addSettings['bigdata'];
    }

    if (isset($arCurrentValues['BXR_EXT_LIST_SETTINGS_SALELEADER'])
        && $arCurrentValues['BXR_EXT_LIST_SETTINGS_SALELEADER'] == "Y"){
        $allSettings['saleleader'] = $addSettings['saleleader'];
    }

    if (isset($arCurrentValues['BXR_EXT_LIST_SETTINGS_VIEWED'])
        && $arCurrentValues['BXR_EXT_LIST_SETTINGS_VIEWED'] == "Y"){
        $allSettings['viewed'] = $addSettings['viewed'];
    }

    if (isset($arCurrentValues['BXR_EXT_LIST_SETTINGS_RECOMMENDED'])
        && $arCurrentValues['BXR_EXT_LIST_SETTINGS_RECOMMENDED'] == "Y"){
        $allSettings['recommended'] = $addSettings['recommended'];
    }

    if (isset($arCurrentValues['BXR_EXT_LIST_SETTINGS_SEARCH'])
        && $arCurrentValues['BXR_EXT_LIST_SETTINGS_SEARCH'] == "Y"){
        $allSettings['search'] = $addSettings['search'];
    }
};

foreach ($allSettings as $cell=>$val){
        $additionalParams = \Alexkova\Bxready2\Component::getCustomListSettings(
                12,
                $arCurrentValues,
                $val['settings'],
                $val['addContext'],
                $val['addTitle']
        );

    

	if (is_array($additionalParams)){

		if (count($additionalParams['LIST_GROUPS'])>0){
			foreach ($additionalParams['LIST_GROUPS'] as $cell=>$val){
				$arComponentGroups[$cell] = $val;
			}
		}

		if (count($additionalParams['LIST_PARAMS'])>0){
			foreach ($additionalParams['LIST_PARAMS'] as $cell=>$val){
				$arTemplateParameters[$cell] = $val;
			}
		}
	}
}