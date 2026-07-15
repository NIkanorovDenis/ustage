<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>



<div class="row">

	<?$firstTab = true;?>

	<div class="col-xs-12 hidden-xs">
		<ul class="bxr-detail-tabs ">
			<?foreach ($arTabs['TABS'] as $cell=>$val):?>
				<?$tab=$_SERVER['DOCUMENT_ROOT'].$this->GetFolder()."/include/tabs/tab.".strtolower($cell).".php";?>
				<?if (file_exists($tab)):?>
					<li  data-tab="<?=$cell?>"<?if($firstTab) echo 'class="active"'?>>
						<?if (strlen($arTabs['DETAIL'][$cell]['GLYPH'])>0):?>
							<span class="<?=$arTabs['DETAIL'][$cell]['GLYPH']?>"></span>
						<?endif;?>
						<?=$arTabs['DETAIL'][$cell]['CAPTION']?>
					</li>
				<?endif;?>
				<?if ($firstTab) $firstTab = false;?>
			<?endforeach;?>
		</ul>
	</div>

	<?$firstTab = true;?>

	<div class="col-xs-12">
		<?foreach ($arTabs['TABS'] as $cell=>$val):?>
			<?$tab=$_SERVER['DOCUMENT_ROOT'].$this->GetFolder()."/include/tabs/tab.".strtolower($cell).".php";?>
			<?if (file_exists($tab)):?>
				<div class="bxr-detail-tab" data-tab="<?=$cell?>"<?if($firstTab) echo 'style="display: block"'?>>
					<div class="bxr-detail-tab-title hidden-sm hidden-md hidden-lg">
						<?if (strlen($arTabs['DETAIL'][$cell]['GLYPH'])>0):?>
							<span class="<?=$arTabs['DETAIL'][$cell]['GLYPH']?>"></span>
						<?endif;?>
						<?=$arTabs['DETAIL'][$cell]['CAPTION']?>
					</div>

					<div class="bxr-detail-tab-content">
						<?include($tab);?>
					</div>
				</div>
			<?endif;?>
			<?if ($firstTab) $firstTab = false;?>
		<?endforeach;?>
	</div>

</div>