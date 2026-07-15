$(document).ready(function(){

	$('.project-slider').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		speed: 500,
		arrows: true,
		prevArrow: '<button type="button" class=" slick-prev"></button>',
		nextArrow: '<button type="button" class=" slick-next"></button>',
		dots: false,
		infinite: true,
		responsive: [
			{
				breakpoint: 800,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 500,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	$('#bxr-services-popupLabel').html('Записаться на экскурсию');
	
})