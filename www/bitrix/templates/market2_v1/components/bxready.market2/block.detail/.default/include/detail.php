<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>

<?if (in_array('DETAIL_TEXT', $arParams['FIELD_CODE'])):?>
    <div itemscope itemtype="https://schema.org/Article">
        <div style="display: none" itemprop="name"><?=$arResult['NAME']?></div>
        <div class="bxr-detail tb20"  itemprop="articleBody" data-scroll="DETAIL">
            <?php if (isset($arResult['PROPERTIES']['PICTURE_LEFT']['VALUE']) && !empty($arResult['PROPERTIES']['PICTURE_LEFT']['VALUE'])): ?>
                <img src="<?= CFile::GetPath($arResult['PROPERTIES']['PICTURE_LEFT']['VALUE']) ?>" alt="" style="float:left; margin: 0 20px 20px 0">
                <p style="float:left;"><?=$arResult['DETAIL_TEXT']?></p>
            <?php else: ?>
                <?=$arResult['DETAIL_TEXT']?>
            <?php endif; ?>
        </div>
    </div>
<?endif;?>
<?php if ($arResult['IBLOCK_ID'] == 14): ?>
    <?php $allotment_array = ['SOUND', 'LIGHT', 'VENUE']; ?>

    <?php foreach ($allotment_array as $i => $value): ?>
        <?php if (isset($arResult['PROPERTIES'][$value.'_TITLE']['VALUE']) && !empty($arResult['PROPERTIES'][$value.'_TITLE']['VALUE'])): ?>
            <section class="allotment allotment_sound">
                <h2 class="allotment__title bxr-h2"><?=$arResult['PROPERTIES'][$value.'_TITLE']['VALUE'] ?></h2>
                <?php if (!empty($arResult['PROPERTIES'][$value.'_IMAGES']['VALUE'])): ?>
                    <div class="allotment__slider">
                        <?php $allotment_sliders_picture = $arResult['PROPERTIES'][$value.'_IMAGES']['VALUE']; ?>
                        <?php include('allotment_slider.php') ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($arResult['PROPERTIES'][$value.'_TEXT']['VALUE']['TEXT'])): ?>
                    <p class="allotment__text bxr-detail"><?=$arResult['PROPERTIES'][$value.'_TEXT']['VALUE']['TEXT']?></p>
                <?php endif; ?>
            </section>
            <?php if (!$i): ?>
                <?php //include($_SERVER['DOCUMENT_ROOT'].'/services/sect_bxr.php') ?>
                <div class="services-form"></div>
            <?php endif; ?>
        <?php endif ?>
    <?php endforeach; ?>

    <?php if (isset($arResult['PROPERTIES']['INSTALLATION_PROCESS']['VALUE']) && !empty($arResult['PROPERTIES']['INSTALLATION_PROCESS']['VALUE']) ): ?>
        <section class="installation bxr-section">
            <h2 class="bxr-h2">Процесс инсталляции</h2>
            <div class="installation__grid">
                <?php foreach ($arResult['PROPERTIES']['INSTALLATION_PROCESS']['VALUE'] as $i => $value): ?>
                    <div class="installation__item">
                        <p class="installation__text bxr-detail">
                            <span class="installation__number"><?=($i+1)?>. </span><?=$value?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    
    <? if ($arResult["PROPERTIES"]["PROJECTS"]["VALUE"]): ?>
        <div class="h2">Реализованные проекты</div>
        <?php include('projects_slider.php') ?>
    <? endif; ?>
    



    <div class="services-form"></div>

        <?php
        $services = CIBlockElement::GetList([],
                ['IBLOCK_ID'=>14],
            false,
            null ,
                 ['ID' , 'NAME' , 'DETAIL_PAGE_URL' , 'PREVIEW_PICTURE']
        );
        ?>
        <section class="other-services-section" style="margin-top: 50px;">
            <h2 class="bxr-h2">Другие услуги</h2>
            <div class="services-list-flex bxr-section">
                <?php while ($arItem = $services->Fetch()): ?>
                    <?php if ($arItem['ID'] != $arResult['ID']): ?>
                        <div class="bxr-news-horizontal-v1" data-uid="1" data-resize="1" style="height: 110px;">
                            <div class="bxr-section-container" style="height: 110px;">
                                <div class="bxr-element-image">
                                    <a href="/<?=$arItem['IBLOCK_CODE']?>/<?=$arItem['CODE']?>/" class="imageContainer imageLoadedContainer">
                                        <img src="<?= CFile::GetPath($arItem['PREVIEW_PICTURE']) ?>" alt="" class="" style="display: inline; max-width: 100px;">
                                    </a>
                                </div>
                                <div class="bxr-element-content">
                                    <div class="bxr-element-name" style="height: 24px;">
                                        <a href="/<?=$arItem['IBLOCK_CODE']?>/<?=$arItem['CODE']?>/"><?=$arItem['NAME']?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </section>
<?php endif; ?>


