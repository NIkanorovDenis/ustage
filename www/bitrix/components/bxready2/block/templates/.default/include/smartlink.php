<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (count($arGlobalSmartLink)>0):?>
	<div class="row tb20-bottom">
	<div class="col-xs-12">
	<ul class="bxr-detail-top-tabs">
		<?foreach ($arGlobalSmartLink as $cell=>$val):?>
			<?if ($arParams['BXR_DETAIL_TAB_TYPE'] == 'list'){
				$val['TYPE'] = 'all';
			}?>
			<li data-tab="<?=$val['LINK']?>" data-type="<?=$val['TYPE']?>">
				<?=$val['NAME']?>
			</li>
		<?endforeach;?>
		<div class="clearfix"></div>
	</ul>
	</div></div>

<?endif;?>