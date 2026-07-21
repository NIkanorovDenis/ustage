<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

CJSCore::Init(array("popup"));
?>
<div class="bx_login_block bxr-font-color">
    <span id="login-line" class="fa fa-user"></span>
	<?
	$frame = $this->createFrame("login-line", false)->begin();
		if ($arResult["FORM_TYPE"] == "login")
		{
		?>
			<a class="bx_login_top_inline_link" href="javascript:void(0)<?//=$arResult["AUTH_URL"]?>" onclick="openAuthorizePopup()"><?=GetMessage("AUTH_LOGIN_POPUP")?></a>
			<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
			<a class="bx_login_top_inline_link" href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow" ><?=GetMessage("AUTH_REGISTER")?></a>
			<?endif;
		}
		else
		{
			$name = trim($USER->GetFullName());
			if (strlen($name) <= 0)
				$name = $USER->GetLogin();
		?>
			<a class="bx_login_top_inline_link" href="<?=$arResult['PROFILE_URL']?>"><?=htmlspecialcharsEx($name);?></a>
			<a class="bx_login_top_inline_link" href="<?=$APPLICATION->GetCurPageParam("logout=yes", Array("logout"))?>"><?=GetMessage("AUTH_LOGOUT")?></a>
		<?
		}
	$frame->beginStub();
		?>
		<a class="bx_login_top_inline_link" href="javascript:void(0)<?//=$arResult["AUTH_URL"]?>" onclick="openAuthorizePopup()"><?=GetMessage("AUTH_LOGIN_POPUP")?></a>
		<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
			<a class="bx_login_top_inline_link" href="<?=$arResult["AUTH_REGISTER_URL"]?>" ><?=GetMessage("AUTH_REGISTER")?></a>
		<?endif;
	$frame->end();
	?>
</div>
<?if ($arResult["FORM_TYPE"] == "login"):?>
	<div id="bx_auth_popup_form" style="display:none;" class="bx_login_popup_form">
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "popup_auth",
		array(
				"BACKURL" => $arResult["~BACKURL"],
				"AUTH_FORGOT_PASSWORD_URL" => $arResult["~AUTH_FORGOT_PASSWORD_URL"],
						"AUTH_REGISTER_URL" => $arResult["~AUTH_REGISTER_URL"],
		),
		false
	);
	?>
	</div>

	<script>
		function openAuthorizePopup()
		{
			<?
			$sizes = "width:400px;height:300px";
			$allowSocAuth = COption::GetOptionString("main","allow_socserv_authorization","Y");
			if($allowSocAuth == "Y" && $arResult["AUTH_SERVICES"])
				$sizes =  "width:500px;height:400px";
			?>
			var authPopup = BX.PopupWindowManager.create("AuthorizePopup", null, {
				autoHide: true,
				zIndex: 100000,
				zIndexOptions: {
					alwaysOnTop: 100000,
					overlayGap: -5
				},
				offsetLeft: 0,
				offsetTop: 0,
				overlay : true,
				draggable: {restrict:true},
				closeByEsc: true,
				closeIcon: {},
				titleBar: {content: BX.create("span", {html: "<div class='bxr-color bxr-border-bottom-color' ><?=GetMessage("AUTH_TITLE");?></div>"})},
				content: '<div style="<?=$sizes?>; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="<?=$this->GetFolder()?>/images/wait.gif"/></span></div>',
				events: {
					onAfterPopupShow: function()
					{
						this.setContent(BX("bx_auth_popup_form"));

						// Keep the site header below this popup and its overlay.
						var popupNode = BX("AuthorizePopup");
						var overlayNode = BX("popup-window-overlay-AuthorizePopup");

						if (popupNode)
							popupNode.style.setProperty("z-index", "100000", "important");

						if (overlayNode)
							overlayNode.style.setProperty("z-index", "99995", "important");
					}
				}
			});

			authPopup.show();
		}
	</script>
<?endif?>
