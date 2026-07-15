<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;
use \Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class energosoft_discounts extends CModule
{
	var $MODULE_ID = 'energosoft.discounts';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $PARTNER_NAME;
	var $PARTNER_URI;

	function __construct()
	{
		$arModuleVersion = array();
		include(__DIR__.'/version.php');

		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		$this->MODULE_NAME = Loc::getMessage('ENERGOSOFT.DISCOUNTS_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('ENERGOSOFT.DISCOUNTS_MODULE_DESC');

		$this->PARTNER_NAME = GetMessage('ENERGOSOFT.DISCOUNTS_PARTNER_NAME');
		$this->PARTNER_URI = GetMessage('ENERGOSOFT.DISCOUNTS_PARTNER_URI');
	}

	function DoInstall()
	{
		\Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
		$this->InstallEvents();
		$this->InstallFiles();
	}

	function DoUninstall()
	{
		$this->UnInstallFiles();
		$this->UnInstallEvents();

		\Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
		Option::delete($this->MODULE_ID);
	}

	function InstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();
		$eventManager->registerEventHandlerCompatible('sale', 'OnCondSaleActionsControlBuildList', $this->MODULE_ID, '\Energosoft\Discounts\Property', 'GetControlDescr');
		$eventManager->registerEventHandler('sale', '\Bitrix\Sale\Internals\Discount::OnAfterAdd', $this->MODULE_ID, '\Energosoft\Discounts\Events', 'OnDiscountAfterUpdate');
		$eventManager->registerEventHandler('sale', '\Bitrix\Sale\Internals\Discount::OnAfterUpdate', $this->MODULE_ID, '\Energosoft\Discounts\Events', 'OnDiscountAfterUpdate');
		$eventManager->registerEventHandlerCompatible('catalog', 'OnGetDiscount', $this->MODULE_ID, '\Energosoft\Discounts\Events', 'OnGetDiscount');
		$eventManager->registerEventHandlerCompatible('catalog', 'OnGetDiscountResult', $this->MODULE_ID, '\Energosoft\Discounts\Events', 'OnGetDiscountResult');
		$eventManager->registerEventHandlerCompatible('main', 'OnProlog', $this->MODULE_ID, '\Energosoft\Discounts\DiscountsHelper', 'OnProlog');
		return true;
	}

	function UnInstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();
		$eventManager->unRegisterEventHandler('sale', 'OnCondSaleActionsControlBuildList', $this->MODULE_ID, '\Energosoft\Discounts\Property', 'GetControlDescr');
		$eventManager->unRegisterEventHandler('sale', '\Bitrix\Sale\Internals\Discount::OnAfterAdd', $this->MODULE_ID, '\Energosoft\Discounts\Events', 'OnDiscountAfterUpdate');
		$eventManager->unRegisterEventHandler('sale', '\Bitrix\Sale\Internals\Discount::OnAfterUpdate', $this->MODULE_ID, '\Energosoft\Discounts\Events', 'OnDiscountAfterUpdate');
		$eventManager->unRegisterEventHandler('catalog', 'OnGetDiscount', $this->MODULE_ID, '\Energosoft\Discounts\Events', 'OnGetDiscount');
		$eventManager->unRegisterEventHandler('catalog', 'OnGetDiscountResult', $this->MODULE_ID, '\Energosoft\Discounts\Events', 'OnGetDiscountResult');
		$eventManager->unRegisterEventHandler('main', 'OnProlog', $this->MODULE_ID, '\Energosoft\Discounts\DiscountsHelper', 'OnProlog');
		return true;
	}

	function InstallFiles()
	{
		return true;
	}

	function UnInstallFiles()
	{
		return true;
	}
}
?>