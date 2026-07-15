<?
IncludeModuleLangFile(__FILE__);

class energosoft_utils extends CModule
{
	var $MODULE_ID = "energosoft.utils";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;

	function energosoft_utils()
	{
		$arModuleVersion = array();
		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->PARTNER_NAME = GetMessage("ES_COMPANY_NAME");
		$this->PARTNER_URI = "http://energo-soft.ru/";
		$this->MODULE_NAME = GetMessage("ES_MODULE_UTILS_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("ES_MODULE_UTILS_DESCRIPTION");
		return true;
	}

	function DoInstall()
	{
		RegisterModule($this->MODULE_ID);

		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/bitrix/",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/", true, true);

		RegisterModuleDependences("iblock", "OnAfterIBlockSectionAdd", $this->MODULE_ID, "ESEvents", "OnAfterIBlockSectionAdd");
		RegisterModuleDependences("iblock", "OnAfterIBlockSectionUpdate", $this->MODULE_ID, "ESEvents", "OnAfterIBlockSectionUpdate");
		RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", $this->MODULE_ID, "ESEvents", "OnAfterIBlockElementAdd");
		RegisterModuleDependences("iblock", "OnAfterIBlockElementUpdate", $this->MODULE_ID, "ESEvents", "OnAfterIBlockElementUpdate");
		RegisterModuleDependences("catalog", "OnBeforePriceAdd", $this->MODULE_ID, "ESEvents", "OnBeforePriceAdd");
		RegisterModuleDependences("catalog", "OnBeforePriceUpdate", $this->MODULE_ID, "ESEvents", "OnBeforePriceUpdate");
		RegisterModuleDependences("catalog", "OnBeforeProductAdd", $this->MODULE_ID, "ESEvents", "OnBeforeProductAdd");
		RegisterModuleDependences("catalog", "OnBeforeProductUpdate", $this->MODULE_ID, "ESEvents", "OnBeforeProductUpdate");
		RegisterModuleDependences("catalog", "OnStoreProductAdd", $this->MODULE_ID, "ESEvents", "OnStoreProductAdd");
		RegisterModuleDependences("catalog", "OnStoreProductUpdate", $this->MODULE_ID, "ESEvents", "OnStoreProductUpdate");

		return true;
	}

	function DoUninstall()
	{
		COption::RemoveOption($this->MODULE_ID);

		UnRegisterModuleDependences("iblock", "OnAfterIBlockSectionAdd", $this->MODULE_ID, "ESEvents", "OnAfterIBlockSectionAdd");
		UnRegisterModuleDependences("iblock", "OnAfterIBlockSectionUpdate", $this->MODULE_ID, "ESEvents", "OnAfterIBlockSectionUpdate");
		UnRegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", $this->MODULE_ID, "ESEvents", "OnAfterIBlockElementAdd");
		UnRegisterModuleDependences("iblock", "OnAfterIBlockElementUpdate", $this->MODULE_ID, "ESEvents", "OnAfterIBlockElementUpdate");
		UnRegisterModuleDependences("catalog", "OnBeforePriceAdd", $this->MODULE_ID, "ESEvents", "OnBeforePriceAdd");
		UnRegisterModuleDependences("catalog", "OnBeforePriceUpdate", $this->MODULE_ID, "ESEvents", "OnBeforePriceUpdate");
		UnRegisterModuleDependences("catalog", "OnBeforeProductAdd", $this->MODULE_ID, "ESEvents", "OnBeforeProductAdd");
		UnRegisterModuleDependences("catalog", "OnBeforeProductUpdate", $this->MODULE_ID, "ESEvents", "OnBeforeProductUpdate");
		UnRegisterModuleDependences("catalog", "OnStoreProductAdd", $this->MODULE_ID, "ESEvents", "OnStoreProductAdd");
		UnRegisterModuleDependences("catalog", "OnStoreProductUpdate", $this->MODULE_ID, "ESEvents", "OnStoreProductUpdate");

		DeleteDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/bitrix/",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/");

		UnRegisterModule($this->MODULE_ID);
		return true;
	}
}
?>