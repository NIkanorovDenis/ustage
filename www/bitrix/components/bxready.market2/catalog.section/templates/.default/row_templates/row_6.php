<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<div class="col-xs-12">
	<div class="row">
		<?foreach ($rowItems as $item) {?>
			<div class="col-xs-6 col-sm-4 col-md-2">
				<?
				$generalParams['BXR_PRESENT_SETTINGS'] = $arParams['BXR_SMALL'];
				$generalParams["BXREADY_USER_TYPES"] = $arParams['BXR_SMALL']["BXREADY_USER_TYPES"];
				$generalParams["BXREADY_USER_TYPE_VARIANT"] = $arParams['BXR_SMALL']["BXREADY_USER_TYPE_VARIANT"];
                $elementDraw->showElement("elements",
                    $arParams['BXR_SMALL']['BXREADY_ELEMENT_DRAW'],
                    $item,
                    $generalParams + array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
                );
				?>
			</div>
		<?}?>
	</div>
</div>