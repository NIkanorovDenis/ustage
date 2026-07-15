<?
$module_id = "alexkova.market2";
if (strlen(COption::GetOptionString($module_id, "bxr_org_name")) > 0):
	if (COption::GetOptionString($module_id, "bxr_org_opengraph") == "Y"):?>
		<meta property="og:title" content="<?=COption::GetOptionString($module_id, "bxr_org_name")?>"/>
		<meta property="og:description" content="<?=COption::GetOptionString($module_id, "bxr_org_description")?>"/>
		<meta property="og:image" content="<?=SITE_SERVER_NAME.CFile::GetPath(COption::GetOptionString($module_id, "bxr_org_logo"))?>">
		<meta property="og:type" content="website"/>
		<meta property="og:url" content= "<?=SITE_SERVER_NAME?>" />
	<?endif;
endif;?>