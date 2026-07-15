<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
    use Bitrix\Main\Localization\Loc;
    $uniqueId = 'tree_'.$arParams["BLOCK_ID"];    
?>
<div class="bxr24-filter-info bxr24-landing-block">
	<div class="bxr24-block-wrapper">
		<div class="copyright"><span>BXREADY</span></div>
		<div class="icon filter-icon">

		</div>
		<div class="content">
			<div class="caption"><?=Loc::getMessage("BXR24_FILTER_PRESET_CAPTION");?></div>
			<div class="description"><?=Loc::getMessage("BXR24_FILTER_PRESET_DESCRIPTION");?></div>
		</div>
		<div class="actions">
			<?if (is_array($arResult['CONDITIONS']) && !empty($arResult['CONDITIONS'])):?>
				<a href="/bitrix/admin/alexkova.bxready24_filter_preset_edit.php?&ID=<?=$arParams['FILTER_PRESET_ID']?>&lang=ru" target="_blank"><?=Loc::getMessage("BXR24_FILTER_PRESET_EDIT");?></a>
			<?else:?>
				<a href="/bitrix/admin/alexkova.bxready24_filter_preset_edit.php?&lang=ru" target="_blank"><?=Loc::getMessage("BXR24_FILTER_PRESET_CREATE");?></a>
			<?endif;?>
		</div>
		<script>
			BX.debugEnableFlag = false;
		</script>

		<?
		if (is_array($arResult['CONDITIONS']) && !empty($arResult['CONDITIONS'])) {

			$f_CONDITIONS = $arResult['CONDITIONS'];
			$obCond = new CCatalogCondTree();
			$boolCond = $obCond->Init(BT_COND_MODE_DEFAULT, BT_COND_BUILD_CATALOG, array('FORM_NAME' => 'post_form', 'CONT_ID' => $uniqueId, 'JS_NAME' => 'JSCatCond_'.$arParams['FILTER_PRESET_ID'], 'PREFIX' => 'COND_FILTER'));
			
                        if (!$boolCond)
			{
				if ($ex = $APPLICATION->GetException())
					echo $ex->GetString()."<br>";
			}
			else
			{
				$obCond->Show($f_CONDITIONS);
			}

		}

		?>

	</div>
	<div class="footer">
		<form name="post_form">
			<div class="bxr24-filter-preset">
				<div class="filter-name"><?=$arResult['NAME']?></div>
				<div id="<?=$uniqueId?>" name="<?=$uniqueId?>">
					<div class="bxr24-form-shadow"></div>
				</div>

			</div>
		</form>
	</div>
</div>