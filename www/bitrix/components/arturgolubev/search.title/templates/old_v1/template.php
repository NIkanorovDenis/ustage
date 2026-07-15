<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");

$themeClass = 'theme-'.COption::GetOptionString("arturgolubev.smartsearch", 'color_theme', 'blue');
$placeholder = trim(COption::GetOptionString("arturgolubev.smartsearch", 'input_search_placeholder'));

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "smart-title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "smart-title-search";

$PRELOADER_ID = CUtil::JSEscape($CONTAINER_ID."_preloader_item");
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
<div id="<?echo $CONTAINER_ID?>" class="bx-searchtitle <?=$themeClass?>">
	<form action="<?echo $arResult["FORM_ACTION"]?>">
		<div class="bx-input-group">
			<input id="<?echo $INPUT_ID?>" placeholder="<?=$placeholder?>" type="text" name="q" value="<?=htmlspecialcharsbx($_REQUEST["q"])?>" autocomplete="off" class="bx-form-control"/>
			<span class="bx-input-group-btn">
				<span class="bx-searchtitle-preloader <?if($arResult["MODULE_SETTING"]["SHOW_PRELOADER"] == 'Y') echo 'view';?>" id="<?echo $PRELOADER_ID?>"></span>
				<button class="" type="submit" name="s"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</form>
</div>
<?endif?>

<script>
	BX.ready(function(){
		new JCTitleSearchAG({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			// 'WAIT_IMAGE': '/bitrix/components/arturgolubev/search.title/templates/.default/images/loading3.gif',
			'PRELODER_ID': '<?echo $PRELOADER_ID?>',
			'MIN_QUERY_LEN': 2
		});
	});
</script>

