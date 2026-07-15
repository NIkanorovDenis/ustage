<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (!empty($arResult["ITEMS"])): ?>

	<? 
	$this->addExternalCss('/bitrix/templates/market2_v1/components/bxready.market2/block.detail/.default/include/slider.css?17397982744831');
	$this->addExternalJS('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.js');
	$this->addExternalCss('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.css');
	$this->addExternalJS("/bitrix/js/alexkova.bxready2/slick/slick.js");
	$this->addExternalCss("/bitrix/js/alexkova.bxready2/slick/slick.css");
	?>

	<div class="ustage-lego">
		<? foreach ($arResult["ITEMS"] as $k=>$item): ?>
		
			<? if (!empty($item['BANNER'])):  /*banner*/ ?>
			
				<div class="ustage-lego_banner" style="background-image:url('<?= $item['BANNER']['IMG'] ?>')">
					<div class="ustage-lego_banner-text">
						<?= $item['BANNER']['TEXT'] ?>
					</div>
				</div>
				
			<? elseif (!empty($item['CITATA'])):  /*citata*/ ?>
			
				<div class="ustage-lego_citata">
					<div class="ustage-lego_citata-img">
						<? if ($item['CITATA']['IMG']):?>
							<img loading="lazy" src="<?= $item['CITATA']['IMG'] ?>" alt="" >
						<? else: ?>
							<?= $item['CITATA']['SVG'] ?>
						<? endif; ?>
					</div>
					<blockquote>
						<?= $item['CITATA']['TEXT'] ?>
					</blockquote>
				</div>
				
			<? elseif (!empty($item['PHOTO'])):  /*gallery || slider*/ ?>
			
				<div class="ustage-lego_photo">
					<h2><?= $item['NAME'] ?></h2>
				
					<? if (!empty($item['PROPERTIES']['SLIDER']) && $item['PROPERTIES']['SLIDER']['VALUE_XML_ID'] == 'Y'): ?>
						
						<div class="project-slider">
							<? foreach ($item['PHOTO'] as $photo): ?>
							
								<div class="item">
									<a href="<?= $photo['BIG_IMG'] ?>" data-fancybox="slider">
										<img src="<?= $photo['IMG'] ?>" loading="lazy" alt="">
									</a>
									<div class="title">
										<?= $photo['TEXT'] ?>
									</div>
								</div>
						
							<? endforeach; ?>
						</div>
					
					<? else: ?>

						<div class="pr-items">
							<? foreach ($item['PHOTO'] as $photo): ?>
							
								<div class="pr-item">
									<a href="<?= $photo['BIG_IMG'] ?>" data-fancybox="photo" class="pr-item-img " style="background-image:url('<?= $photo['IMG'] ?>');"></a>
									<div class="pr-item-info">
										<?= $photo['TEXT'] ?>
									</div>
							   </div>
								
							<? endforeach; ?>
						</div>
						
					<? endif; ?>
					
				</div>
				
			<? elseif (!empty($item['DETAIL_TEXT'])):  /*2 col*/ ?>	
				<? if (empty($item['PROPERTIES']['HIDE_TITLE']) || 
				(isset($item['PROPERTIES']['HIDE_TITLE']['VALUE_XML_ID']) && $item['PROPERTIES']['HIDE_TITLE']['VALUE_XML_ID'] != 'Y')): ?>
					<h2><?= $item['NAME'] ?></h2>
				<? endif;?>
				<div class="ustage-lego_item-cols">
					<div class="ustage-lego_item-col ">
						<?= $item['~PREVIEW_TEXT'] ?>
					</div>
					<div class="ustage-lego_item-col">
						<?= $item['~DETAIL_TEXT'] ?>						
					</div>
				</div>			
				
			<? else: /*text*/ ?>
			
				<div class="ustage-lego_item">
					<?= $item['~PREVIEW_TEXT'] ?>
				</div>
			
			<? endif; ?>
			
			
		<? endforeach; ?>
	</div>

<? endif; ?>
<div class="services-form" id="form_apply"></div>