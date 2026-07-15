<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);
global $USER, $containerXlClass;
$push_menu_top = $push_menu_bottom = false;
if($arParams["BXR_MOBILE_SHOW_USER_FORM"]== "Y" || $arParams["BXR_MOBILE_SHOW_ANSWER_FORM"] == "Y" || $arParams["BXR_MOBILE_SHOW_PHONE_FORM"] == "Y" ||
   $arParams["BXR_MOBILE_SHOW_CHART_FORM"] == "Y" || $arParams["BXR_MOBILE_SHOW_HEART_FORM"] == "Y" ||  $arParams["BXR_MOBILE_SHOW_BASKET_FORM"] == "Y"){
        $push_menu_top = true;
}

if($arParams["BXR_MOBILE_SHOW_SEARCH_FORM"] == "Y" || !empty($arResult)) {
  $push_menu_bottom = true; }
?>

<?if($push_menu_bottom || $push_menu_top):?>
    <?
        $theme_class = "";
        $arStyle = array(
            "classTop" => "",
            "classLi" => "bxr-bg-hover-flat",
            "classLiHover" => "bxr-color",
        );       
        switch ($arParams['STYLE_MENU']) {
            case "colored_color":
                $arStyle["classTop"] = "bxr-color-flat";
                $arStyle["classLi"] = "bxr-bg-hover-dark-flat";
                $arStyle["classLiHover"] = "bxr-color-dark-flat";
                break;
            case "colored_dark":
                $arStyle["classTop"] = "bxr-dark-flat";
                break;
        }
    ?>
    <nav data-hoverClass="<?=$arStyle["classLiHover"];?>" class="bxr-mobile-push-menu-v2 <?=$arStyle["classTop"];?>">
        <?if($push_menu_top):?>
            <div class="<?=(!$push_menu_bottom)?"bxr-w100":"";?> bxr-mobile-push-menu-top pull-right">
                <ul class="bxr-mobile-push-menu-button">
                    <?if ($arParams["BXR_MOBILE_SHOW_USER_FORM"] == "Y"):?>
                        <?if ($USER->isAuthorized()):?>
                            <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-user" data-target='auth-data'>
                                <a href="#" class='managment' onclick="return false;">
                                    <i class="fa fa-user fa-fw"></i>
                                </a>
                            </li>
                        <?else:?>
                            <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-user" data-target=''>
                                <a href="<?=$arParams["BXR_USER_LINK"];?>">
                                    <i class="fa fa-user fa-fw"></i>
                                </a>
                            </li>
                        <?endif;?>
                    <?endif;?>

                    <?if ($arParams["BXR_MOBILE_SHOW_ANSWER_FORM"] == "Y"):?>
                        <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-contacts" data-target='contacts'><i class="fa fa-envelope fa-fw"></i></li>
                    <?endif;?>

                    <?if ($arParams["BXR_MOBILE_SHOW_PHONE_FORM"] == "Y"):?>
                        <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-phone" data-target='phone'><i class="fa fa-phone fa-fw"></i></li>
                    <?endif;?>

                    <?if ($arParams["BXR_MOBILE_SHOW_CHART_FORM"] == "Y"):?>
                        <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-chart" data-target='chart'>
                            <?if (!empty($arParams["BXR_COMPARE_LINK"])):?>
                                <a rel="nofollow" href="<?=$arParams["BXR_COMPARE_LINK"];?>">
                                    <i class="fa fa-bar-chart fa-fw"></i>
                                </a>
                            <?else:?>
                                <i class="fa fa-bar-chart fa-fw"></i>
                            <?endif;?>
                        </li>
                    <?endif;?>

                    <?if ($arParams["BXR_MOBILE_SHOW_HEART_FORM"] == "Y"):?>
                        <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-heart" data-target='heart'>
                            <?if (!empty($arParams["BXR_FAVORITES_LINK"])):?>
                                <a href="<?=$arParams["BXR_FAVORITES_LINK"];?>">
                                    <i class="fa fa-heart-o fa-fw"></i>
                                </a>
                            <?else:?>
                                <i class="fa fa-heart-o fa-fw"></i>
                            <?endif;?>
                        </li>
                    <?endif;?>

                    <?if ($arParams["BXR_MOBILE_SHOW_BASKET_FORM"] == "Y"):?>
                        <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-basket" data-target='basket'>
                            <?if (!empty($arParams["BXR_BASKET_LINK"])):?>
                                <a href="<?=$arParams["BXR_BASKET_LINK"];?>">
                                    <i class="fa fa-shopping-basket fa-fw"></i>
                                </a>
                            <?else:?>
                                <i class="fa fa-shopping-basket fa-fw"></i>
                            <?endif;?>
                        </li>
                    <?endif;?>
                </ul>
            </div>
        <?endif;?>

        <?if($push_menu_bottom):?>
            <div class="<?=(!$push_menu_top)?"bxr-w100":"";?> bxr-mobile-push-menu-bottom">
                <ul class="bxr-mobile-push-menu-button">
                    <?if (!empty($arResult)):?>
                        <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-menu" data-target='menu' data-show='N'><i class="fa fa-bars fa-fw"></i><span><?=GetMessage("BXR_MOBILE_MENU_TEXT");?></span></li>
                    <?endif;?>

                    <?if ($arParams["BXR_MOBILE_SHOW_SEARCH_FORM"] == "Y"):?>
                        <li class="<?=$arStyle["classLi"];?> bxr-mobile-menu-button-search" data-target='search'><i class="fa fa-search fa-fw"></i>
                            <?if( \COption::GetOptionString( 'alexkova.market2', "regions_mode"."_".SITE_TEMPLATE_ID, "N") != "Y"):?>
                                <span><?=GetMessage("BXR_MOBILE_SEARCH_TEXT");?></span>
                            <?endif;?>
                        </li>
                    <?endif;?>

                    <?if( \COption::GetOptionString( 'alexkova.market2', "regions_mode"."_".SITE_TEMPLATE_ID, "N") == "Y"):?>
                        <li class="<?=$arStyle["classLi"];?>" data-target='region' ><i class="fa fa-map-marker fa-fw"></i></li>
                    <?endif;?>
                </ul>
            </div>
        <?endif;?>
    </nav>
    <div class="clearfix"></div>
    <?if (!empty($arResult)):?>
        <nav class="bxr-mobile-push-menu">
            <div class="bxr-mobile-push-menu-content">
                <div id="bxr-mobile-menu-body">
                    <div class="bxr-mobile__tabs">

                        <div class="bxr-mobile__tabs--links">
                            <button type="button" class="bxr-mobile__tabs--link active" data-tab-id="mobile-catalog">Каталог</button>
                            <button type="button" class="bxr-mobile__tabs--link" data-tab-id="mobile-info">Информация</button>
                        </div><!--/bxr-mobile__tabs--links-->

                        <div class="bxr-mobile__tabs--content">
                            <div class="bxr-mobile__tab-content active" id="mobile-catalog">
                                <? $APPLICATION->IncludeComponent(
                                    "bxready.market2:menu",
                                    "simple_list",
                                    array(
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "CHILD_MENU_TYPE" => "left",
                                        "COMPONENT_TEMPLATE" => "simple_list",
                                        "DELAY" => "N",
                                        "MAX_LEVEL" => "3",
                                        "MENU_CACHE_GET_VARS" => array(),
                                        "MENU_CACHE_TIME" => "36000",
                                        "MENU_CACHE_TYPE" => "A",
                                        "MENU_CACHE_USE_GROUPS" => "N",
                                        "ROOT_MENU_TYPE" => "catalog_mobile",
                                        "USE_EXT" => "Y",
                                        "BXR_MOBILE_SHOW_SEARCH_FORM" => "Y",
                                        "BXR_MOBILE_SHOW_ANSWER_FORM" => "Y",
                                        "BXR_MOBILE_SHOW_PHONE_FORM" => "Y",
                                        "BXR_MOBILE_SHOW_USER_FORM" => "Y",
                                        "CACHE_SELECTED_ITEMS" => false,
                                        "BXR_MOBILE_SHOW_CHART_FORM" => "Y",
                                        "BXR_MOBILE_SHOW_HEART_FORM" => "Y",
                                        "BXR_MOBILE_SHOW_BASKET_FORM" => "Y",
                                        "BXR_COMPARE_LINK" => "/catalog/compare.php",
                                        "BXR_FAVORITES_LINK" => "/personal/favorites/",
                                        "BXR_BASKET_LINK" => "/personal/basket/",
                                        "STYLE_MENU" => "colored_light",
                                        "BXR_USER_LINK" => "/personal/profile/"
                                    ),
                                    false
                                ); ?>
                               
                            </div><!--//bxr-mobile__tab-content-->

                            <div class="bxr-mobile__tab-content" id="mobile-info">
                                <ul id="bxr-multilevel-menu" data-child="0">
                                    <?
                                        $previousLevel = 0;
                                        $isPreviousParent = false;

                                        foreach($arResult as $cell=>$arItem):?>
                                            <?
                                            $normalizedLevel = $arItem['DEPTH_LEVEL'];

                                            if ($previousLevel) {
                                            if ($isPreviousParent) {
                                                if ($normalizedLevel > $previousLevel && ($normalizedLevel - $previousLevel) > 1) {
                                                $normalizedLevel = $previousLevel + 1;
                                                }
                                            } elseif ($normalizedLevel > $previousLevel) {
                                                $normalizedLevel = $previousLevel;
                                            }
                                            }
                                            ?>

                                            <?if ($previousLevel && $normalizedLevel < $previousLevel): ?>
                                            <?=str_repeat("</ul></li>", ($previousLevel - $normalizedLevel));?>
                                            <?endif?>

                                            <?if ($arItem["IS_PARENT"]):
                                                $oldparent = $cell;
                                                $parent = $cell++;
                                            ?>
                                            
                                                <li class="parent 1 " data-depth="<?= $normalizedLevel ?>" data-parent="<?=$parent?>" data-child="<?=$oldparent?>">
                                                    <? if ($arItem["PARAMS"]["ico_dark"]): ?><span class='444 bxr-ico-left-hover-menu'><? $img = CFile::ResizeImageGet($arItem["PARAMS"]["ico_dark"], array('width'=>32, 'height'=>32), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?><img  src='<?=$img['src']?>' alt='<?=$arItem["TEXT"]?>'></span><? endif; ?><?=$arItem["TEXT"]?> <span class="direction fa fa-chevron-right"></span>
                                                </li>

                                                <li class="content-child" data-parent="<?=$parent?>"  data-child="<?=$oldparent?>"><ul>
                                                    <li class="child bxr-color bxr-color-light-hover" data-parent="<?=$parent?>">
                                                        <?=GetMessage('BXR_PUSH_MENU_LEFT')?> <span class="direction fa fa-chevron-left"></span>
                                                    </li>

                                                    <li class="child-title">
                                                        <a class="bxr-color-dark" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                                                        <span class="menu-arrow-top bxr-border-color-dark"></span>
                                                    </li>
                                            <?else:?>
                                                <li data-depth="<?= $normalizedLevel ?>"><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><? if ($arItem["PARAMS"]["ico_dark"]): ?><span class='555 bxr-ico-left-hover-menu'><? $img = CFile::ResizeImageGet($arItem["PARAMS"]["ico_dark"], array('width'=>32, 'height'=>32), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?><img  src='<?=$img['src']?>' alt='<?=$arItem["TEXT"]?>'></span><? endif; ?> <?=$arItem["TEXT"]?></a></li>
                                            <?endif?>

                                            <?$previousLevel = $normalizedLevel;?>
                                            <?$isPreviousParent = $arItem["IS_PARENT"];?>
                                        <?endforeach?>

                                    <?if ($previousLevel > 1)://close last item tags?>
                                            <?=str_repeat("</ul>", ($previousLevel-1) );?>
                                    <?endif?>
                                </ul>
                            </div><!--//bxr-mobile__tab-content-->

                        </div><!--/bxr-mobile__tabs--content-->
                        
                    </div><!--/bxr-mobile__tabs-->
                        
                </div>
            </div>
        </nav>
        <div class="clearfix"></div>
    <?endif?>

    <?if($push_menu_top || $push_menu_bottom):?>
        <div class="hidden-md hidden-lg">
            <div class="col-xs-12">
                <?if ($arParams["BXR_MOBILE_SHOW_SEARCH_FORM"] == "Y"):?>
                        <div id="bxr-mobile-search" class="bxr-mobile-slide row">
                            <div class="col-xs-12 bxr-p20">
                                <?$APPLICATION->IncludeComponent(
                                        "bxready.market2:main.include",
                                        "named_area",
                                        Array(
                                                "AREA_FILE_SHOW" => "file",
                                                "AREA_FILE_SUFFIX" => "inc",
                                                "EDIT_TEMPLATE" => "",
                                                "PATH" => SITE_DIR."include/mobile_search.php",
                                                "INCLUDE_PTITLE" => GetMessage("GHANGE_MOBILE_SEARCH")
                                        ),
                                        false
                                );?>
                            </div>
                        </div>
                <?endif;?>
                <?if ($arParams["BXR_MOBILE_SHOW_PHONE_FORM"] == "Y"):?>
                    <div id="bxr-mobile-phone" class="bxr-mobile-slide row">
                        <div class="col-xs-12 bxr-p20">
                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include",
                                "named_area",
                                Array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => SITE_DIR."include/mobile_phone.php",
                                        "INCLUDE_PTITLE" => GetMessage("GHANGE_MOBILE_PHONE")
                                ),
                                false
                            );?>
                        </div>
                    </div>
                <?endif;?>
                <?if ($arParams["BXR_MOBILE_SHOW_ANSWER_FORM"] == "Y"):?>
                    <div id="bxr-mobile-contacts" class="bxr-mobile-slide row">
                        <div class="col-xs-12 bxr-p20">
                            <?$APPLICATION->IncludeComponent(
                                    "bxready.market2:main.include",
                                    "named_area",
                                    Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "AREA_FILE_SUFFIX" => "inc",
                                            "EDIT_TEMPLATE" => "",
                                            "PATH" => SITE_DIR."include/mobile_contacts.php",
                                            "INCLUDE_PTITLE" => GetMessage("GHANGE_MOBILE_CONTACTS")
                                    ),
                                    false
                            );?>
                        </div>
                    </div>
                <?endif;?>
                <?if (true):?>
                    <div id="bxr-mobile-auth-data" class="bxr-mobile-slide row">
                        <div class="col-xs-12 bxr-p20">
                            <div class="bxr-profile">
                                <a href="<?=$arParams['BXR_USER_LINK']?>">
                                    <i class="fa fa-user"></i> <?=GetMessage('BXR_MOBILE_MENU_PROFILE')?>
                                </a>
                                <a href="/?logout=yes">
                                    <i class="fa fa-sign-out"></i> <?=GetMessage('BXR_MOBILE_MENU_LOGOUT')?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?endif;?>
                <?/*if ($arParams["BXR_MOBILE_SHOW_USER_FORM"] == "Y"):?>
                    <div id="bxr-mobile-user" class="bxr-mobile-slide row">
                        <div class="col-xs-12 bxr-p20">
                                <?$basketFrame = new \Bitrix\Main\Page\FrameHelper("bxr_login_frame");
                                $basketFrame->begin();?>
                                <?$APPLICATION->IncludeComponent(
                                        "bitrix:system.auth.form",
                                        "popup",
                                        array(
                                                "REGISTER_URL" => SITE_DIR."auth/",
                                                "FORGOT_PASSWORD_URL" => SITE_DIR."auth/",
                                                "PROFILE_URL" => SITE_DIR."personal/profile/",
                                                "SHOW_ERRORS" => "Y",
                                                "COMPONENT_TEMPLATE" => "popup"
                                        ),
                                        false
                                );?>
                                <?$basketFrame->beginStub();
                                echo "...";
                                $basketFrame->end();?>
                        </div>
                    </div>
                <?endif;*/?>
            </div>
        </div>
        <div class="clearfix"></div>
    <?endif?>
<?endif;?>
