<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$searchResult = array();
?>
<div class="search-page">
<form action="" method="get">
	<div class="row">
		<div class="col-xs-8">
			<input type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
		</div>
		<div class="col-xs-4">
			<input class="bxr-color-button" type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
		</div>
	</div>
	<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />

</form><br />

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>

<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
<?elseif($arResult["ERROR_CODE"]!=0):?>
	<p><?=GetMessage("SEARCH_ERROR")?></p>
	<?ShowError($arResult["ERROR_TEXT"]);?>
	<p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
	<br /><br />
	<p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
	<table border="0" cellpadding="5">
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
			<td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
			<td><?=GetMessage("SEARCH_AND_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
			<td><?=GetMessage("SEARCH_OR_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
			<td><?=GetMessage("SEARCH_NOT_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top">( )</td>
			<td valign="top">&nbsp;</td>
			<td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
		</tr>
	</table>
<?elseif(count($arResult["SEARCH"])>0):?>
	<?if($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
	<br />

	<?foreach($arResult["SEARCH"] as $arItem){
		$searchResult[] = $arItem['ITEM_ID'];
	};

	if (count($searchResult)>0){

		if ($arParams['EXPORT_PARENT_PARAMS']["BXR_EXT_LIST_SETTINGS_MODE"] == "Y" || $arParams['EXPORT_PARENT_PARAMS']["BXR_EXT_LIST_SETTINGS_SEARCH"] != "Y")
			$allBXRPrefix = array('_OTHER');
		else
			$allBXRPrefix = array('_SEARCH');

		$additionalListParams = array();
		foreach ($allBXRPrefix as $prefix) {
			foreach ($arParams['EXPORT_PARENT_PARAMS'] as $cell => $val){
				if (substr_count($cell, "~") > 0) continue;
				if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix){
					$additionalListParams[str_replace ($prefix, '_LISTPAGE', $cell)] =  $val;
				}
			}

			$arGridParams = array(
				"BXREADY_LIST_XLG_CNT".$prefix,
				"BXREADY_LIST_LG_CNT".$prefix,
				"BXREADY_LIST_MD_CNT".$prefix,
				"BXREADY_LIST_SM_CNT".$prefix,
				"BXREADY_LIST_XS_CNT".$prefix
			);
			if ($viewedGrid == 'col' && in_array($cell, $arGridParams))
				$additionalListParams[str_replace ($prefix, '_LISTPAGE', $cell)] =  12;
		}

		global $searchFilter;
		$searchFilter = array(
			'ID' => $searchResult
		);

		$arViewedParams = array_merge($arParams['EXPORT_LIST_PARAMS'], $additionalListParams);
                $arViewedParams['USE_FILTER_SORT'] = "Y";
                $arViewedParams["REGION"] = (isset($arParams["REGION"]) && !empty($arParams["REGION"])) ? $arParams["REGION"] : "";
                $arViewedParams["BXR_AJAX_REGION_INFO"] = (isset($arParams["BXR_AJAX_REGION_INFO"]) && !empty($arParams["BXR_AJAX_REGION_INFO"])) ? $arParams["BXR_AJAX_REGION_INFO"] : "";

		$intSectionID = $APPLICATION->IncludeComponent(
			"bxready.market2:catalog.section",
			"bxready",
			$arViewedParams,
			false,
			array("HIDE_ICONS" => "Y")
		);

	}

	?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
	<br />
	<p>
	<?if($arResult["REQUEST"]["HOW"]=="d"):?>
		<a href="<?=$arResult["URL"]?>&amp;how=r<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>"><?=GetMessage("SEARCH_SORT_BY_RANK")?></a>&nbsp;|&nbsp;<b><?=GetMessage("SEARCH_SORTED_BY_DATE")?></b>
	<?else:?>
		<b><?=GetMessage("SEARCH_SORTED_BY_RANK")?></b>&nbsp;|&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d<?echo $arResult["REQUEST"]["FROM"]? '&amp;from='.$arResult["REQUEST"]["FROM"]: ''?><?echo $arResult["REQUEST"]["TO"]? '&amp;to='.$arResult["REQUEST"]["TO"]: ''?>"><?=GetMessage("SEARCH_SORT_BY_DATE")?></a>
	<?endif;?>
	</p>
<?else:?>
	<?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
<?endif;?>
</div>
