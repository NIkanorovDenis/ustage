<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Alexkova\Bxready24\Data\FilterPresetTable,
	Alexkova\Bxready24\Cond,
	Bitrix\Main\Loader,
	Bitrix\Main\Application,
	Bitrix\Main\Web\Uri;

//Loc::loadMessages(__FILE__);

if (
!\Bitrix\Main\Loader::includeModule('alexkova.bxready24')
|| !\Bitrix\Main\Loader::includeModule('iblock')
|| !\Bitrix\Main\Loader::includeModule('catalog')
)  return;

class BXReady24SaleFilterPreset extends CBitrixComponent
{
	protected function prepareResult()
	{

		$preset = FilterPresetTable::getById($this->arParams['FILTER_PRESET_ID']);
		if ($arPreset = $preset->Fetch()) {
			$descr = unserialize($arPreset['DESCR']);
			$filter = $descr['CONDITIONS'];

			if (is_array($filter)) {
				$this->arResult['CONDITIONS'] = $filter;
				$this->arResult['NAME'] = $arPreset['NAME'];
				$this->arResult['FILTER'] = Cond::conditionToGetList($filter, $descr['IBLOCK_ID']);
			}

			$this->SetResultCacheKeys(array('FILTER'));

		} else {
			$this->AbortResultCache();
		}

		$this->arResult['AJAX_URL'] = $this->getPath().'/ajax.php';
	}


	public function executeComponent()
	{
		if (!is_array($this->arResult)) $this->arResult = array();

		if ($this->StartResultCache()) {

			if ($this->arParams['FILTER_PRESET_ID'] > 0) {
				$this->prepareResult();
			}

			$uri = new Uri(Application::getInstance()->getContext()->getRequest()->getRequestUri());
			$this->arResult['PAGE'] = $uri->getPath();

			$this->includeComponentTemplate();

		}

		global $arrFilter;

		if (is_array($this->arResult['FILTER'])) {
			$arrFilter = $this->arResult['FILTER'];
		}
	}
}