<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if($arParams[NOINDEX_WIDGET]=="Y"){?><!--googleoff: all--><!--noindex--><?}?>
<div class="zaiv-instagram-widget-container">
	<?if(!count($arResult[ERRORS])){?>
		<div class="zaiv-instagram-widget-header">
			<?if($arParams[SHOW_INSTAGRAM_LOGO]=="Y"){
				if($arParams[INSTAGRAM_LOGO_TYPE]=="BIG"){?>
					<a class="zaiv-instagram-widget-instagram-logo-big" href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank"></a>
				<?}?>
				<a class="zaiv-instagram-widget-instagram-logo-small <?=($arParams[INSTAGRAM_LOGO_TYPE]=="BIG")?"hidden":""?>" href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank"></a>
			<?}?>
			<?if($arResult[OWNER][AVATAR]){?>
				<a class="zaiv-instagram-widget-avatar-link zaiv-instagram-widget-avatar-link-<?=strtolower($arParams[ACCOUNT_AVATAR_SIZE])?> zaiv-instagram-widget-avatar-link-mobile-<?=strtolower($arParams[ACCOUNT_AVATAR_SIZE_MOBILE])?>" href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank" style="background-image:url(<?=$arResult[OWNER][AVATAR]?>)"></a>
			<?}?>
			<div class="zaiv-instagram-widget-next-to-avatar zaiv-instagram-widget-next-to-<?=strtolower($arParams[ACCOUNT_AVATAR_SIZE_MOBILE])?>-avatar-mobile <?=($arParams[SHOW_ACCOUNT_INFO]=="N" && $arParams[SHOW_ACCOUNT_DESCRIPTION]=="N")?"only-name":""?>">
				<a class="zaiv-instagram-widget-username" href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank">
					<!--<img class="insta-logo" src="https://scontent-arn2-1.cdninstagram.com/v/t51.2885-19/s320x320/58619945_902151066783243_6548688270031585280_n.jpg?tp=1&_nc_ht=scontent-arn2-1.cdninstagram.com&_nc_ohc=N1IHusRzoAIAX8xxZZR&oh=fa57e3cb400d292a934b12ecedc5734c&oe=6068A38C" alt="ustagegroup" />	-->
					<img class="insta-logo" src="/logo.svg" alt="ustagegroup" style="border-radius: 0px;" />					 
					<span>@<?if(
							(
								(!$arParams[NAME_TYPE] || $arParams[NAME_TYPE]=="USERNAME")
								&& $arResult[OWNER][USERNAME]
							)
							||
							(
								$arParams[NAME_TYPE]=="FULLNAME" && !$arResult[OWNER][FULLNAME]
							)
						){
						echo $arResult[OWNER][USERNAME];
					}else{
						echo $arResult[OWNER][FULLNAME];
					}?></span>  
				</a>
				<?if($arParams[SHOW_ACCOUNT_INFO]!="N"){?>
				<div class="zaiv-instagram-widget-account-info <?=($arParams[SHOW_ACCOUNT_INFO_TYPE]=="TYPE1")?"zaiv-instagram-widget-account-info-vertical-type":""?>">
						<?if($arResult[OWNER][MEDIA_COUNT]){?>
							<div><a style="font-size:12px;" href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank"><span class="title-name"><?=$arResult[OWNER][MEDIA_COUNT]?></span> <?=GetMessage("TEMPLATE_PUBLICATIONS")?></a></div>
						<?}?>
						<?if($arResult[OWNER][FOLLOWED_COUNT]){?>
							<div><a style="font-size:12px;" href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank"><span class="title-name"><?=$arResult[OWNER][FOLLOWED_COUNT]?></span> <?=GetMessage("TEMPLATE_FOLLOWED")?></a></div>
						<?}?>
						<?if($arResult[OWNER][FOLLOWS_COUNT]){?>
							<div><a style="font-size:12px;" href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank"><span class="title-name"><?=$arResult[OWNER][FOLLOWS_COUNT]?></span> <?=GetMessage("TEMPLATE_FOLLOWS")?></a></div>
						<?}?>
					</div>
				<?}?>
				<?if($arParams[SHOW_ACCOUNT_DESCRIPTION]!="N" && $arResult[OWNER][DESCRIPTION]){?>
					<div class="zaiv-instagram-widget-account-description"><?=$arResult[OWNER][DESCRIPTION]?></div>
				<?}?>
			</div>
			<div class="zaiv-instagram-widget-account-small-screen">
				<?if($arParams[SHOW_ACCOUNT_DESCRIPTION]!="N"){?>
					<div class="zaiv-instagram-widget-account-description"><?=$arResult[OWNER][DESCRIPTION]?></div>
				<?}?>
				<?if($arParams[SHOW_ACCOUNT_INFO]!="N"){?>
					<div class="zaiv-instagram-widget-account-info <?=($arParams[SHOW_ACCOUNT_INFO_TYPE_MOBILE]=="TYPE1")?"zaiv-instagram-widget-account-info-vertical-type":""?>">
						<div><a href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank"><span class="title-name"><?=$arResult[OWNER][MEDIA_COUNT]?></span> <?=GetMessage("TEMPLATE_PUBLICATIONS")?></a></div>
						<div><a href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank"><span class="title-name"><?=$arResult[OWNER][FOLLOWED_COUNT]?></span> <?=GetMessage("TEMPLATE_FOLLOWED")?></a></div>
						<div><a href="<?=$arResult[OWNER][LINK_INSTAGRAM]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank"><span class="title-name"><?=$arResult[OWNER][FOLLOWS_COUNT]?></span> <?=GetMessage("TEMPLATE_FOLLOWS")?></a></div>
					</div>
				<?}?>
			</div>
		</div>
	<div class="zaiv-instagram-widget-media w<?=($arParams[MEDIA_ROW_COUNT])?$arParams[MEDIA_ROW_COUNT]:"8"?> <?=($arParams[MEDIA_ROW_COUNT]>5)?"wide":""?>">
			<?foreach($arResult[ITEMS] as $arItem){?>
				<a href="<?=$arItem[LINK]?>" <?=($arParams[NOINDEX_LINKS]=="Y")?'rel="nofollow"':''?> target="_blank" style="background-image:url(<?=$arItem[IMAGE]?>)"></a>
			<?}?>
		</div>
	<?}else{
		foreach($arResult[ERRORS] as $errorItem){
			echo "<div class=\"zaiv-instagram-gallery-error\">$errorItem</div>";
		}
	}?>
</div>
<?if($arParams[NOINDEX_WIDGET]=="Y"){?><!--/noindex--><!--googleon: all--><?}?>