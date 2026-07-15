$(document).ready(function() {

	$('.bxr-indicator-item-favor').addClass('bxr-indicator-item-active');

	$(document).on(
	    'click',
	    'form.bxr-basket-action .bxr-basket-favor',
	    function() {
	        let row = $(this).closest('[data-entity=items-row]');
	        $(row).remove();
	    }
	);

});