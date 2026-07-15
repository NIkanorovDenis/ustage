<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$this->setFrameMode(true);
if(is_array($arParams["COLS"])) {
    $maxCols = max($arParams["COLS"]);
    $minCols = min($arParams["COLS"]);
    $arParams["COLS_SORT"] = array(
        "xs" => intval($arParams["COLS"]["xs"])?:$minCols,
        "sm" => intval($arParams["COLS"]["sm"])?:$minCols,
        "md" => intval($arParams["COLS"]["md"])?:$maxCols,
        "lg" => intval($arParams["COLS"]["lg"])?:$maxCols,
        "xl" => intval($arParams["COLS"]["xl"])?:$maxCols,
    );
}
 else {
    $maxCols = intval($arParams["COLS"])?:1;
    $arParams["COLS_SORT"] = array(
        "xs" => 1,
        "sm" => 1,
        "md" => $maxCols,
        "lg" => $maxCols,
        "xl" => $maxCols,
    );
}

if(!function_exists('footerPrintMenuCol'))
{
	function footerPrintMenuCol($items, $options)
	{
		$maxLevel = intval($options["MAX_LEVEL"]);
		$addUlClass = $options["UL_CLASS"];
		?>
		<ul <?if($addUlClass) echo "class='{$addUlClass}'"?>>
			<?
			foreach($items as $item):
				if($maxLevel == 1 && $item["DEPTH_LEVEL"] > 1)
					continue;
				?>
                <li class="bxr-children-color-hover"><a href="<?=$item["LINK"]?>"><?=$item["TEXT"]?></a></li>
			<?endforeach?>

		</ul>
	<?}
}
?>
<?if (!empty($arResult)):
	if($maxCols > 1):
		$arrChunked = array_chunk($arResult, ceil(count($arResult) / $maxCols));
                $adaptCols = array(
                    "xs" => ceil(12/$arParams["COLS_SORT"]["xs"]),
                    "sm" => ceil(12/$arParams["COLS_SORT"]["sm"]),
                    "md" => ceil(12/$arParams["COLS_SORT"]["md"]),
                    "lg" => ceil(12/$arParams["COLS_SORT"]["lg"]),
                    "xl" => ceil(12/$arParams["COLS_SORT"]["xl"]),
                );
		foreach ($arrChunked as $key=>$items):?>
			<div class="col-xl-<?=$adaptCols["xl"]?> col-lg-<?=$adaptCols["lg"]?> col-md-<?=$adaptCols["md"]?> col-sm-<?=$adaptCols["sm"]?> col-xs-<?=$adaptCols["xs"]?> bxr-footer-col">
				<?
				$addUlClass = '';
				if($key == 0)
					$addUlClass = 'first';
				footerPrintMenuCol($items, array('MAX_LEVEL'=>$arParams["MAX_LEVEL"], "UL_CLASS"=>$addUlClass));?>
			</div>
		<?endforeach?>
	<?else:?>
		<div class="col-xs-12 bxr-footer-col">
			<?footerPrintMenuCol($arResult, array('MAX_LEVEL'=>$arParams["MAX_LEVEL"],"UL_CLASS"=>'first'));?>
		</div>
	<?endif;?>
<?endif?>