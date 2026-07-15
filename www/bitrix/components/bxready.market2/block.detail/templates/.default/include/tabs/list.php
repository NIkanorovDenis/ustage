<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>



<div class="row">


	<?$firstTab = true;?>

	<div class="col-xs-12">
		<?foreach ($arTabs['TABS'] as $cell=>$val):?>
			<?$tab=$_SERVER['DOCUMENT_ROOT'].$this->GetFolder()."/include/tabs/tab.".strtolower($cell).".php";?>
			<?if (file_exists($tab)):?>

				<div class="bxr-detail-tab-title bxr-detail" data-scroll="<?=$cell?>">
					<?if (strlen($arTabs['DETAIL'][$cell]['GLYPH'])>0):?>
						<span class="<?=$arTabs['DETAIL'][$cell]['GLYPH']?>"></span>
					<?endif;?>
					<?=$arTabs['DETAIL'][$cell]['CAPTION']?>
				</div>

				<div class="bxr-detail-tab-content">
					<?include($tab);?>
				</div>

			<?endif;?>
		<?endforeach;?>
	</div>

</div>