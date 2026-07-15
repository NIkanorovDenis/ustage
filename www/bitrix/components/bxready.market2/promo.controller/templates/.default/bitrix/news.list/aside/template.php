<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

$hoverEffectFile = ($arParams['HOVER_EFFECT']) ? $arParams['HOVER_EFFECT'] : 'default';
$displayTypeClass = ($arParams['DISPLAY_TYPE']) ? $arParams['DISPLAY_TYPE'] : 'block';

$elementHeight = intval($arParams['BXR_PROMO_BLOCK_HEIGHT']) > 0 ? intval($arParams['BXR_PROMO_BLOCK_HEIGHT']) : 250;
$elementHeightStr = strval($elementHeight).'px';

$addStyle = 'height: '.$elementHeightStr;

global $unicumID;
if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

?>

<div class="row bxr-promo-ribbon bxr-promo-<?=$displayTypeClass?>">
  <div class="bxr-slider" id="slider_<?= $unicumID?>" accesskey="" style="position: relative; height: <?= $elementHeightStr?>;">
    <? foreach ($arResult["ITEMS"] as $key => $arItem):
      if ($arItem['ID'] == 40402) continue;
      ?>
      <div class="slick-slide">
        <div class="row">
          <?
          $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
          $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
          ?>
          <div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="bxr-promo-element <?=$arItem['PROPERTIES']["LG_COL_COUNT"]['VALUE_XML_ID']?> <?=$arItem['PROPERTIES']["MD_COL_COUNT"]['VALUE_XML_ID']?> <?=$arItem['PROPERTIES']["SM_COL_COUNT"]['VALUE_XML_ID']?> <?=$arItem['PROPERTIES']["XS_COL_COUNT"]['VALUE_XML_ID']?>" style="height: <?= $elementHeightStr?>;">
            <?
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/include/'.$hoverEffectFile.'.php')
              && $arItem['PROPERTIES']["PROMO_NO_EFFECT"]['VALUE']!='Y') {
              include ($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/include/'.$hoverEffectFile.'.php');
            } else {
              include ($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/include/default.php');
              $this->addExternalCss($this->GetFolder().'/include/css/default.css');
            }
            ?>
          </div>
        </div>
      </div>
    <?endforeach;?>
  </div>

  <? foreach ($arResult["ITEMS"] as $key => $arItem):
    if ($arItem['ID'] != 40402) continue;
    ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div id="<?=$this->GetEditAreaId($arItem['ID']);?>"
         class="bxr-promo-element <?=$arItem['PROPERTIES']["LG_COL_COUNT"]['VALUE_XML_ID']?> <?=$arItem['PROPERTIES']["MD_COL_COUNT"]['VALUE_XML_ID']?> <?=$arItem['PROPERTIES']["SM_COL_COUNT"]['VALUE_XML_ID']?> <?=$arItem['PROPERTIES']["XS_COL_COUNT"]['VALUE_XML_ID']?>"
         style="<?=$addStyle?>">
      <?
      if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/include/'.$hoverEffectFile.'.php')
        && $arItem['PROPERTIES']["PROMO_NO_EFFECT"]['VALUE']!='Y')
      {
        include ($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/include/'.$hoverEffectFile.'.php');
      }
      else
      {
        include ($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/include/default.php');
        $this->addExternalCss($this->GetFolder().'/include/css/default.css');
      }
      ?>
    </div>
  <?endforeach;?>
</div>

<?
//����������� css
if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/include/css/'.$hoverEffectFile.'.css'))
    $this->addExternalCss($this->GetFolder().'/include/css/'.$hoverEffectFile.'.css');
else
    $this->addExternalCss($this->GetFolder().'/include/css/default.css');
?>

<?
$mainId = $this->GetEditAreaId($navParams['NavNum']);
$obSlName = 'obSl'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
?>
<script>
  (function() {
    var <?=$obSlName?> = new JCPromoBlockControllerSlider({
      uniqId: '<?=$unicumID?>',
      dots: <?=($arParams["LIST_SLIDER_MARKERS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
      infinite: <?=($arParams["SLIDER_INFINITE"] == "Y") ? 'true' : 'false'?>,
      speed: <?= (intval($arParams['SLIDER_SPEED']) > 0) ? $arParams['SLIDER_SPEED'] : 500?>,
      autoPlay: <?=($arParams["SLIDER_AUTOPLAY"] == "Y") ? 'true' : 'false'?>,
      autoPlaySpeed: <?=intval($arParams["SLIDER_AUTOPLAY_SPEED"])>0 ? intval($arParams["SLIDER_AUTOPLAY_SPEED"]) :  2000?>,
      fade: <?= ($arParams['SLIDER_FADE']=="Y") ? "true" : "false" ?>,
      hideDesktop: <?=($arParams["HIDE_SLIDER_ARROWS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
      hideMobile: <?=($arParams["HIDE_MOBILE_SLIDER_ARROWS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
      <?if(isset($arAdapt)){?>
      break: {
        <?foreach ($arAdapt as $key => $break){
          echo $key.":{ point:".$break["POINT"].",height:\"".$break["HEIGHT"]."\",hidden:\"".$break["HIDDEN"]."\"},";
        }?>
      }
      <?}?>
    });
  })(jQuery);
</script>
