<?
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
Loc::loadMessages(__FILE__);
$isSend=$arResult['IS_SEND'];
if(!empty($isSend)){?>
<span id="sw24buycheaperlink"><?=$arParams['AFTER_SEND_TITLE']?></span>
<?}else{
$this->addExternalCss("/bitrix/components/bitrix/system.show_message/templates/.default/style.css");

$linkTitle=(empty($arParams['TITLE']))?Loc::getMessage("skyweb24.buycheaper_T_TITLEDEFAULT"):$arParams['TITLE'];
$buttonTitle=(empty($arParams['BUTTON_SEND']))?Loc::getMessage("skyweb24.buycheaper_T_BUTTON_SEND"):$arParams['BUTTON_SEND'];
$successTitle=(empty($arParams['SUCCESS_TITLE']))?Loc::getMessage("skyweb24.buycheaper_T_SUCCESS_TITLE"):$arParams['SUCCESS_TITLE'];
$afterSendTitle=(empty($arParams['AFTER_SEND_TITLE']))?Loc::getMessage("skyweb24.buycheaper_T_AFTER_SEND_TITLE"):$arParams['AFTER_SEND_TITLE'];

?>

<span id="sw24buycheaperlink"><a href="javascript:void(0);" onclick="send_buycheaper(<?=$arParams['ID_PRODUCT']?>);" class="btn btn-success"><?=$linkTitle?></a></span>
<div class="clearfix"><br></div>
<div style="display:none;">
	<div id="buycheaperPopup<?=$arParams['ID_PRODUCT']?>" class="popup_form_buycheaper">
<h2>Нашли дешевле? Оставьте заявку на скидку.</h2>
		<form action="/bitrix/components/skyweb24/buycheaper/ajax.php">
			<?if(!empty($arResult['ERRORS']) || !empty($arResult['OK'])){
				$APPLICATION->RestartBuffer();
			}?>
			<input type="hidden" value="<?=$arParams['ID_PRODUCT']?>" name="product">
			<?if(!empty($arResult['ERRORS']) && count($arResult['ERRORS'])>0){
				foreach($arResult['ERRORS'] as $keyError=>$nextError){
					showError(Loc::getMessage("skyweb24.buycheaper_T_AFIELDS_".$keyError).' - '.$nextError);
				}
			}?>
			<?if(!empty($arResult['OK'])){
				showNote($successTitle);?>
				<script>
				BX('sw24buycheaperlink').innerHTML='<?=$afterSendTitle?>';
				</script>
			<?}else{?>
				<?foreach($arResult['FORMS'] as $nextField){
					$required=$nextField['REQUIRED']?' class="required"':'';
					?>
					<label>
					<span<?=$required?>><?=Loc::getMessage("skyweb24.buycheaper_T_AFIELDS_".$nextField['CODE'])?></span>
					<?if($nextField['TYPE']=='input'){?>
					<input type="text" name="<?=$nextField['CODE']?>" value="<?=$nextField['VALUE']?>">
					<?}else{?>
					<textarea name="<?=$nextField['CODE']?>"><?=$nextField['VALUE']?></textarea>
					<?}?>
					</label>
				<?}?>
				<label>
					<input type="submit" value="<?=$arParams['BUTTON_SEND']?>">
				</label>
			<?}?>
			<?if(!empty($arResult['ERRORS']) || !empty($arResult['OK'])){
				die();
			}?>
		</form>
	</div>
</div>
<script>
	var sw24Buycheaper<?=$arParams['ID_PRODUCT']?>={
		params:<?=CUtil::PhpToJSObject($arParams)?>
	};
	
function send_buycheaper(idProduct){
	var settings=window['sw24Buycheaper'+idProduct];
	var cForm=document.querySelector('#buycheaperPopup'+idProduct+' form');
	cForm.onsubmit=function(e){
		e.preventDefault();
		var elements = this.querySelectorAll( "input, select, textarea" ), obj={};
		for(var i = 0; i < elements.length; i++) {
			var element = elements[i];
			if(element.name && element.value){
				obj[element.name] = element.value;
			}
		}
		
		BX.ajax({
			url: this.action,
			data: {
				'params':settings.params,
				'form':obj
			},
			method: 'POST',
			dataType: 'html',
			//dataType: 'json',
			timeout:300,
			scriptsRunFirst:true,
			async: true,
			onsuccess: function(data){
				cForm.innerHTML=data;
			},
			onfailure: function(data){
				console.warn(data);
			}
		});
		
		return false;
	}
	var popup = new BX.PopupWindow("popup-buycheaper", null, {
		content: BX('buycheaperPopup'+idProduct),
		autoHide : true,
		zIndex: 0,
		offsetTop : 1,
		offsetLeft : 0,
		className: 'sw24Buycheaper',
		lightShadow : true,
		closeIcon : true,
		closeByEsc : true,
		onPopupClose: function() {},
		overlay:{
			backgroundColor:'#000'
		}
	});
	popup.show();
}	
</script>
<?}?>

<style>.popup_form_buycheaper{padding:10px;}
.popup_form_buycheaper label{width:400px; display:block; margin-top:10px;}
.popup_form_buycheaper label span{width:100%;}
.popup_form_buycheaper label span.required:after{content:'*'; display:inline-block; margin-left:5px; color:#f00;}
.popup_form_buycheaper label input, .popup_form_buycheaper label textarea{width:100%; box-sizing:border-box; padding:0 5px; line-height:30px;}
.popup_form_buycheaper label input[type=submit]{width:auto;}
.popup_form_buycheaper label textarea{height:5em; min-height:5em; display:inline-block;}</style>