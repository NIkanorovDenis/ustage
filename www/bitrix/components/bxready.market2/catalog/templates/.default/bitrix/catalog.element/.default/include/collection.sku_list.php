<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?if (!empty($arResult["OFFERS"])):?>
	<div id="<?=$arItemIDs['SKU_WRAP']?>" class="bxr-market-sku-select-wrap bxr-sku-list-wrap">
		<?include_once 'script.php';
		global $firstScuSelect;
		$firstScuSelect = 0;

		$arParams["~OFFERS_PROPERTY_CODE"] = is_array($arParams["~OFFERS_PROPERTY_CODE"])? $arParams["~OFFERS_PROPERTY_CODE"] : array();
		$arResult["OFFERS_PROP"] = is_array($arResult["OFFERS_PROP"])? $arResult["OFFERS_PROP"] : array();

		?>
		<ul class="bxr-sku-select-items bxr-sku-list">
			<?$i = 0;
			foreach($arResult["OFFERS"] as $offer):
				if (is_array($offer["PREVIEW_PICTURE"])) {
					$src = $offer["PREVIEW_PICTURE"]["SRC"];
				} elseif (intval($offer["PREVIEW_PICTURE"]) > 0) {
					$src = CFile::GetPath($offer["PREVIEW_PICTURE"]);
				} elseif (is_array($offer["DETAIL_PICTURE"])) {
					$src = $offer["DETAIL_PICTURE"]["SRC"];
				} elseif (intval($offer["DETAIL_PICTURE"]) > 0) {
					$src = CFile::GetPath($offer["DETAIL_PICTURE"]);
				} elseif ($offer["MORE_PHOTO"][0]["SRC"] && $offer["MORE_PHOTO"][0]["TYPE"] != "NO_PHOTO") {
					$src = $offer["MORE_PHOTO"][0]["SRC"];
				} elseif ($arResult["MORE_PHOTO"][0]["SRC"] && $arParams["SHOW_MAIN_INSTEAD_NF_SKU"] == "Y") {
					$src = $arResult["MORE_PHOTO"][0]["SRC"];
				} else {
					$src = '/bitrix/tools/bxready2/.default/no-image.png';
				}
				?>
				<li class="bxr-sku-select-item <?=$i == 0 ? 'active' : ''?>" data-pid="<?=$offer['ID']?>">
					<div class="bxr-offers-ico <?=$addClass?>">
						<img src="<?=$src?>" alt="<?=$offer["NAME"]?>" title="<?=$offer["NAME"]?>">
					</div>
					<div class="bxr-offers-props">
						<?$propsStr = "";
						foreach($offer["PROPERTIES"] as $propCode => $arProp):
							$printValue = "";
							if (array_key_exists($propCode, $arResult["OFFERS_PROP"]) || in_array($arProp["CODE"], $arParams["~OFFERS_PROPERTY_CODE"])):
								$sPropId = $arResult["SKU_PROPS"][$propCode]["XML_MAP"][$arProp["VALUE"]];
								if ($arProp["PROPERTY_TYPE"] == "E" && strlen($arResult["SKU_PROPS"][$propCode]["VALUES"][$arProp["VALUE"]]["NAME"]) > 0) {
									$printValue = $arProp["NAME"].": ".$arResult["SKU_PROPS"][$propCode]["VALUES"][$arProp["VALUE"]]["NAME"];
								} else if ($arProp["PROPERTY_TYPE"] == "S" && strlen($arResult["SKU_PROPS"][$propCode]["VALUES"][$sPropId]["NAME"]) > 0) {
									$printValue = $arProp["NAME"].": ".$arResult["SKU_PROPS"][$propCode]["VALUES"][$sPropId]["NAME"];
								} else if ($arProp["PROPERTY_TYPE"] == "L" && $arProp["MULTIPLE"] == "Y" && $arProp["VALUE"]) {
									$printValue = $arProp["NAME"].": ";
									$valueCount = count($arProp["VALUE"])-1;
									foreach ($arProp["VALUE"] as $key => $value)
									{
										$printValue .= $value;
										if ($key!=$valueCount) $printValue .= ',';
									}
								} else if (is_string($arProp["VALUE"]) && strlen($arProp["VALUE"]) > 0) {
									$printValue = $arProp["NAME"].": ".$arProp["VALUE"];
								}

								if(!empty($printValue))
									$propsStr .= $printValue.", ";

							endif;
						endforeach;
						$propStr = rtrim($propsStr, ', ');
						if (strlen($propStr) > 0) :
							$propStr = ' <span class="bxr-sku-prop-brackets">('.$propStr.')</span>';
						endif;
						?>
						<span class="bxr-offer-props-name"><?=$offer["NAME"]?></span><?=$propStr?>
					</div>
					<div class="clearfix"></div>
				</li>
				<?$i++;
			endforeach;?>
		</ul>
	</div>
<?endif?>