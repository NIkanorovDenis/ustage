<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//echo "55<pre>"; print_r($arResult['FILTER_SUMMARY']); echo "</pre>";
?>
<div class="bxr-smart-filter-map">
	<div class="title"><?=GetMessage('BXR_SM_DATA_TITLE')?></div>
	<?foreach ($arResult['FILTER_SUMMARY'] as $cell => $val):?>
		<div class="box">
			<span class="name"><?=$val['NAME']?>:</span>
			<?$prefix = ''?>
				<?foreach($val['ITEMS'] as $cell2 => $val2):?>
					<?=$prefix?><span class="item"><?=$val2['VALUE']?></span>
				<?
					$prefix = ', ';
				endforeach;?>
		</div>
	<?endforeach;?>
</div>

<span id ='add_filter_string' style="display: none"><?=$arResult['FILTER_ADD_STRING']?></span>