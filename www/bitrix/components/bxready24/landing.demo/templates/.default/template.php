<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if ($arResult['ERRORS'])
{
	foreach ($arResult['ERRORS'] as $code => $error)
	{
		echo '<p style="color: red;">' . $error . '</p>';
	}
}

if (empty($arResult['DEMO']))
{
	\showError(Loc::getMessage('LANDING_TPL_EMPTY_REPO'));
}

if ($arResult['FATAL'])
{
	return;
}

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$curUrl = $request->getRequestUri();

$bodyClass = $APPLICATION->GetPageProperty('BodyClass');
$APPLICATION->SetPageProperty('BodyClass', ($bodyClass ? $bodyClass.' ' : '') . 'no-all-paddings no-background');
$APPLICATION->setTitle(Loc::getMessage('LANDING_TPL_TITLE'));

\CJSCore::Init(array('popup', 'action_dialog', 'loader', 'sidepanel'));
Asset::getInstance()->addCSS('/bitrix/components/bitrix/landing.sites/templates/.default/style.css');
Asset::getInstance()->addJS('/bitrix/components/bitrix/landing.sites/templates/.default/script.js');

if(!CheckVersion(\Bitrix\Landing\Manager::getVersion(), "18.4.33")):?>
    <div class="adm-info-message-wrap">
        <div class="adm-info-message">
        <span class="required">
            <?=Loc::getMessage('WAR_INSTALL_TEXT')?>
        </span>
        </div>
    </div><?
    return false;
endif;
?>
<div class="grid-tile-wrap bxr24-landing-block" id="grid-tile-wrap">
	<div class="grid-tile-inner" id="grid-tile-inner">

<?foreach ($arResult['DEMO'] as $item):
	if ($item['HIDE'])
	{
		continue;
	}
	$uriSelect = new \Bitrix\Main\Web\Uri($curUrl);
	$uriSelect->addParams(array(
		'tpl' => isset($item['DATA']['items'][0])
				? $item['DATA']['items'][0]
				: $item['ID'],
                'action' => 'install'
	));
	?>
        <div class="bxready-section-template">
            <span class="landing-item-inner">
                <div class="landing-title">
                    <div class="landing-title-wrap">
                        <div class="landing-title-overflow"><?= \htmlspecialcharsbx($item['TITLE'])?></div>
                    </div>
                </div>
                
                <?if (trim($item['DESCRIPTION'])):?>
                    <span class="landing-item-description">
                        <span class="landing-item-desc-inner">
                            <span class="landing-item-desc-overflow">
                                <span class="landing-item-desc-height">
                                    <?= \htmlspecialcharsbx($item['DESCRIPTION'])?>
                                </span>
                            </span>
                            <span class="landing-item-desc-open"></span>
                        </span>
                    </span>
                <?endif?>
                
                <div class="actions">
                    <a target="_blank" href="http://docs.kuznica74.ru/documentation/course/course26/lesson619/"><?=Loc::getMessage('DOCS')?></a>
                    <span data-href="<?= str_replace("alexkova.bxready24_main.php", "alexkova.bxready24_install_site.php", $uriSelect->getUri());?>" class="landing-template-pseudo-link light"><?=Loc::getMessage('INSTALL')?></span>
                </div>
            </span>
            <div class="bxr24-landing-block-gallery">
                <span class="image-bg">
                    <span class="image-shop-scroll" style="width: 100%; background-image: url('<?=$item['DATA']['preview']?>');"></span>
                </span>
            </div>
            <div class="clearfix"></div>
        </div>
<?endforeach;?>
        <div class="clearfix"></div>
	</div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
	BX.ready(function ()
	{
		var items = [].slice.call(document.querySelectorAll('.landing-template-pseudo-link'));

		items.forEach(function(item) {
			if (!BX.hasClass(item, 'landing-item-payment'))
			{
				BX.bind(item, 'click', function(event) {

					if(event.target.classList.contains('landing-item-desc-open'))
					{
						return;
					}

					BX.SidePanel.Instance.open(event.currentTarget.dataset.href+"&"+Date.now(), {
						allowChangeHistory: false
					});
				});
			}
        });

		var wrapper = BX('grid-tile-wrap');
		var tiles = Array.prototype.slice.call(wrapper.getElementsByClassName('landing-item'));
		new BX.Landing.Component.Demo({
			wrapper : wrapper,
			inner: BX('grid-tile-inner'),
			tiles : tiles
		});
		<?if ($arResult['LIMIT_REACHED']):?>
		if (typeof BX.Landing.PaymentAlert !== 'undefined')
		{
			BX.Landing.PaymentAlert({
				nodes: wrapper.querySelectorAll('.landing-item-payment'),
				title: '<?= \CUtil::jsEscape(Loc::getMessage('LANDING_TPL_LIMIT_REACHED_TITLE'));?>',
				message: '<?= ($arParams['SITE_ID'] > 0)
					? \CUtil::jsEscape(Loc::getMessage('LANDING_TPL_PAGE_LIMIT_REACHED_TEXT'))
					: \CUtil::jsEscape(Loc::getMessage('LANDING_TPL_SITE_LIMIT_REACHED_TEXT'));
					?>'
			});
		}
		<?endif;?>
	})
</script>