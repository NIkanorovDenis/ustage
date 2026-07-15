<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$rowItemsCount = count($rowItems);
?>
<div class="col-xs-12 col-sm-6 product-item-small-card">
	<div class="row">
		<?for ($i = 0; $i < $rowItemsCount - 1; $i++) {?>
			<div class="col-xs-6 col-md-4">
				<?
                $generalParams['BXR_PRESENT_SETTINGS'] = $arParams['BXR_SMALL'];
				$generalParams["BXREADY_USER_TYPES"] = $arParams['BXR_SMALL']["BXREADY_USER_TYPES"];
				$generalParams["BXREADY_USER_TYPE_VARIANT"] = $arParams['BXR_SMALL']["BXREADY_USER_TYPE_VARIANT"];
                $elementDraw->showElement("elements",
                    $arParams['BXR_SMALL']['BXREADY_ELEMENT_DRAW'],
                    $rowItems[$i],
                    $generalParams + array('SKU_PROPS' => $arResult['SKU_PROPS'][$rowItems[$i]['IBLOCK_ID']])
                );
				?>
			</div>
		<?}?>
	</div>
</div>
<div class="col-xs-12 col-sm-6 product-item-big-card">
    <?
    $item = end($rowItems);
    $generalParams['BXR_PRESENT_SETTINGS'] = $arParams['BXR_BIG'];
	$generalParams["BXREADY_USER_TYPES"] = $arParams['BXR_BIG']["BXREADY_USER_TYPES"];
	$generalParams["BXREADY_USER_TYPE_VARIANT"] = $arParams[BXR_BIG]["BXREADY_USER_TYPE_VARIANT"];
    $elementDraw->showElement("elements",
        $arParams['BXR_BIG']['BXREADY_ELEMENT_DRAW'],
        $item,
        $generalParams + array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
    );
    unset($item);
    ?>
</div>