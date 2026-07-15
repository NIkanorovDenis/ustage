<?if (count($arResult["IMAGES"]) > 0):?>
	<div class="proj-detail-imgs proj-detail-slick">
		
	<? foreach ($arResult["IMAGES"] as $key => $slide): ?>
		<a class="proj-detail-img img-popup cover" data-fancybox="gallery" rel="projects" href="<?= $slide["SRC"] ?>" style="background: url('<?= $slide["TMB"]["SRC"] ?>') no-repeat center center;"></a>
	<? endforeach; ?>
	
	</div>
	
	<script>
	$(document).ready(function(){
		if ($('.proj-detail-slick').length > 0) {
			$('.proj-detail-slick').slick({
				dots: true,
				draggable: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				arrows: true,
				infinite: true,
				speed: 700,
				autoplay: false,
				autoplaySpeed: 7000,
				responsive: [
				{
				  breakpoint: 768,
				  settings: {
					slidesToShow: 2
				  }
				},
				{
				  breakpoint: 540,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				},
			]
			});

			$('body').on('click', '.proj-detail-slick .slick-arrow', function(){
				$('.proj-detail-slick').slick('slickPause');
			});
		}
	});
</script>	

<?elseif(!empty($arResult["DETAIL_PICTURE"])):?>

	<? $dPict = $arResult["DETAIL_PICTURE"]; ?>
	<div class="bxr-element-slider">
		 <a href="<?= $dPict["SRC"] ?>" data-rel="gallery" data-fancybox="bx-gallery" id="main-photo">
            <img class="img-responsive bxr-zoom-img" src="<?= $dPict["SRC"] ?>" title="<?= $dPict["TITLE"] ?>"
                 alt="<?= $dPict["ALT"] ?>" itemprop="image">
        </a>
	</div>
	
<?endif;?>


