<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var $this \Alexkova\Market2\FormIblockComponent */

if(CModule::IncludeModule("alexkova.bxready2"))
    \Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:form.iblock");

global $BXR_FORM_COUNTER;

/*if (intval($BXR_FORM_COUNTER)<=0)
    $BXR_FORM_COUNTER = 1;
else
    $BXR_FORM_COUNTER++;

if ($arParams['AJAX'] == "Y") {
    $BXR_FORM_COUNTER = $arParams["IDENTITY"];
} else {
    $arParams['COMPONENT_TEMPLATE'] = $this->getTemplateName();
    $arParams["TARGET_URL"] = $this->getPath().'/ajax/form.php';
    $arParams["POST_FORM_URI"] = $this->getPath().'/ajax/form.php';
};*/

$BXR_FORM_COUNTER = $arParams["IDENTITY"];
?>
<?
$this->includeComponentTemplate();
ob_start();

$oneclick = 'oneclick_'.date('d.m.Y H:i'); 
?>

    <script>

	 
      BX.ready(function() {
			
            window.BXReady.Market.showFormSuccess = function(formId, data) {
                    data = '<div class="answer">' + data + '</div>';

                    var form = $('#ajaxFormContainer_'+formId);

                    if ($('.request-product-name', form).length > 0) {
                        var product_name = $('.request-product-name', form).html().trim();
                        if (product_name != '') {
                            var product_id = $('input[name="PROPERTY[14][0]"]', form).val() || ''; //id tovar
                            var offer_id = $('input[name="PROPERTY[15][0]"]', form).val() || ''; //id offer
                            if (offer_id != '') product_id = offer_id;

                            var product_price = $('[itemprop=price]').attr('content') || '';
                            if (product_price == '') {
                                product_price = $('[itemprop=lowPrice]').attr('content') || '';
                            }
                            var product_brand = $('[itemprop=brand]').attr('content') || '';

                            var product_category = '';
                            $('.bxr-breadcrumb .bxr-breadcrumb-item [itemprop=name]').each(function(){ 
                                var item_name = $(this).html().trim();
                                if (item_name != 'Главная' && item_name != 'Каталог' && product_category == '') {
                                    product_category = item_name;
                                }
                            });

							dataLayer.push({
                                'ecommerce': {
                                    'currencyCode': 'RUB',
                                    'purchase': {
                                        'actionField': {
                                            'id' : '<?= $oneclick ?>'
                                        },
                                        'products': [
                                            {
                                                'id': product_id,
                                                'name': product_name,
                                                'price': product_price,
                                                'brand': product_brand,
                                                'category': product_category,
                                                'variant': '',
                                                'quantity': '1'
                                            }
                                        ]
                                    }
                                }
                            });
                        }
                    }

                    form.html(data);
            };

            window.BXReady.Market.formRefresh = function (formId) { 
                
				$('#' + formId + ' button').attr('disabled', 'disabled').addClass('disabled');
				
                BX.ajax.submit(BX(formId), function(data) { 
                    
					dataInc = data.replace(/<div[^>]+>/gi, ''); 
                    
					if (dataInc.substr(0,7) === 'success')  {
                        window.BXReady.Market.showFormSuccess(formId, data.substr(7, data.lenght));
                        return false;
                    } 

                    BX('ajaxFormContainer_' + formId).innerHTML = data;

                });
                return false;
            };

			
        });	 
  
    </script>

<?
$GLOBALS["APPLICATION"]->AddHeadString(ob_get_clean(),true);
?>
