<?global $BXR_FORM_COUNTER;?>

<? if (empty($_REQUEST['FORM_ID'])): ?>
<script>
$(function(){
	
	let pid_bx = $('input[type="hidden"].tovar-id').val();
	if (pid_bx) {
		
		let pid_bxr = BXReady.Market.basketValues[pid_bx]; 
		if (pid_bxr) {
			
			$('input[name="PRODUCT_NAME"').val(pid_bxr['NAME']);	
			$('.request-product-name').text(pid_bxr['NAME']);	
			$('[data-code="TRADE_NAME_HIDDEN"]').val(pid_bxr['NAME']);	

			$('input[name="PRODUCT_IMG"').val(pid_bxr['IMG']);	
			$('.request-product-img img').attr('src', pid_bxr['IMG']);		

			$('[data-code="TRADE_LINK_HIDDEN"]').val(pid_bxr['LINK']);
			
			$('[data-code="TRADE_ID_HIDDEN"]').val(pid_bxr['ID']);
			$('[data-code="OFFER_ID_HIDDEN"]').val(pid_bxr['OFFER_ID']);	
			$('[data-code="TRADE_QTY_HIDDEN"]').val(1);		

			$('[data-code*="USER_COMMENT_AREA"]').each(function(){
				$(this).text($(this).parents('.modal-content').find('.modal-title').text() + ': ' + pid_bxr['NAME']);
			})	

			$('[data-code="COMMENT"]').each(function(){
				$(this).val(pid_bxr['NAME']);
			})				
			
		}
		
	}

});
</script>
<? endif; ?>


