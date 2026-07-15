<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="bx_storage" id="catalog_store_amount_div">
    <div class="bx_storage__title">Наличие в&nbsp;магазинах</div>

    <ul class="c_store_amount">
        <?foreach($arResult["STORES"] as $pid => $arProperty):?>
            <?
                if ($arParams['SHOW_EMPTY_STORE'] == 'N' && isset($arProperty['REAL_AMOUNT']) && $arProperty['REAL_AMOUNT'] <= 0) {
                  continue;
                }

                if ($arProperty['ID'] === '6') { // Магазин в Санкт-Петербурге
                  $showPendingStatus = isset($arProperty['REAL_AMOUNT']) && $arProperty['REAL_AMOUNT'] <= 0 && $arParams['PENDING_QUANTITY'] > 0;

                  if ($showPendingStatus) {
                    $arProperty['AMOUNT'] = 'ожидается';
                  }

                  if (isset($arResult['IS_SKU']) && $arResult['IS_SKU'] == 1) {
                    foreach ($arResult['JS']['SKU'] as $offerId => $sku) {
                      foreach ($sku as $storeId => $amount) {
                        if ($storeId === (int) $arProperty['ID'] && $amount <= 0) {

                          foreach ($arParams['OFFERS'] as $id => $offer) {
                            if ((string) $offerId === (string) $id) {
                              if ($offer['PROPERTIES']['PENDING_QUANTITY']['VALUE'] > 0) {
                                $arResult['JS']['SKU'][$offerId][$storeId] = -1;
                              }

                              break;
                            }
                          }
                        }
                      }
                    }
                  }
                }
            ?>
            <li class="c_store_amount__info">
              <div class="c_store_amount__table c_store_amount__table_theme_<?= CUtil::translit($arProperty['AMOUNT'], 'ru'); ?>">
                <span class="c_store_amount__name"><?= $arParams['SHOW_GENERAL_STORE_INFORMATION'] == "Y" ? GetMessage('BALANCE') : $arProperty["TITLE"] ?>&nbsp;&mdash;</span>

                <span class="c_store_amount__data">
                  <span class="balance" id="<?= $arResult['JS']['ID'] ?>_<?= $arProperty['ID'] ?>"><?= $arProperty["AMOUNT"] ?></span>
                </span>
              </div>

              <?if (isset($arProperty["DESCRIPTION"]) || isset($arProperty["PHONE"]) || isset($arProperty["SCHEDULE"]) || isset($arProperty["EMAIL"])
                || isset($arProperty["COORDINATES"]) || !empty($arProperty['USER_FIELDS']) && is_array($arProperty['USER_FIELDS'])) {?>
                <div class="bxr-store-more-info">
                  <span class="bxr-store-contacts">
                    <?if (isset($arProperty["DESCRIPTION"])):?>
                      <span><?=$arProperty["DESCRIPTION"]?></span><br />
                    <?endif;?>
                    <?if (isset($arProperty["PHONE"])):?>
                      <span class="bxr-store-prop-name"><?=GetMessage('S_PHONE')?></span> <span class="bxr-store-prop-val"><?=$arProperty["PHONE"]?></span>
                    <?endif;?>
                    <?if (isset($arProperty["SCHEDULE"])):?>
                      <span class="bxr-store-prop-name"><?=GetMessage('S_SCHEDULE')?></span> <span class="bxr-store-prop-val"><?=$arProperty["SCHEDULE"]?></span>
                    <?endif;?>
                    <?if (isset($arProperty["EMAIL"])):?>
                      <span class="bxr-store-prop-name"><?=GetMessage('S_EMAIL')?></span> <span class="bxr-store-prop-val"><?=$arProperty["EMAIL"]?></span>
                    <?endif;?>
                    <?if (isset($arProperty["COORDINATES"])):?>
                      <span class="bxr-store-prop-name"><?=GetMessage('S_COORDINATES')?></span> <span class="bxr-store-prop-val"><?=$arProperty["COORDINATES"]["GPS_N"]?>, <?=$arProperty["COORDINATES"]["GPS_S"]?></span>
                    <?endif;?>
                    <?
                    if (!empty($arProperty['USER_FIELDS']) && is_array($arProperty['USER_FIELDS']))
                    {
                      foreach ($arProperty['USER_FIELDS'] as $userField)
                      {
                        if (isset($userField['CONTENT']))
                        {
                          ?><span class="bxr-store-prop-name"><?=$userField['TITLE']?>:</span> <span class="bxr-store-prop-val"><?=$userField['CONTENT']?></span><?
                        }
                      }
                    }
                    ?>
                  </span>
                </div>
              <?}?>
            </li>
        <?endforeach;?>
    </ul>
</div>

<?if (isset($arResult["IS_SKU"]) && $arResult["IS_SKU"] == 1):?>
	<script type="text/javascript">
		var obStoreAmount = new JCCatalogStoreSKU(<? echo CUtil::PhpToJSObject($arResult['JS'], false, true, true); ?>);
	</script>
	<?
endif;?>
