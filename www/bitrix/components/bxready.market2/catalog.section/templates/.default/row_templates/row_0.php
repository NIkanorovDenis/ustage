<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<div class="col-xs-12 product-item-small-card">
	<div class="row">
		<div class="col-xs-12 product-item-big-card">
            <?
            $item = reset($rowItems);
            $generalParams['BXR_PRESENT_SETTINGS'] = $arParams['BXR_BIG'];
			$generalParams["BXREADY_USER_TYPES"] = $arParams['BXR_BIG']["BXREADY_USER_TYPES"];
			$generalParams["BXREADY_USER_TYPE_VARIANT"] = $arParams['BXR_BIG']["BXREADY_USER_TYPE_VARIANT"];
            $elementDraw->showElement("elements",
                $arParams['BXR_BIG']['BXREADY_ELEMENT_DRAW'],
                $item,
                $generalParams + array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
            );
            ?>
		</div>
	</div>
</div>