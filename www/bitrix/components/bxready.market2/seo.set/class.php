<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Application,
	Alexkova\Market2\Data\MarketseoTable as MS;

Loc::loadMessages(__FILE__);

if (
!\Bitrix\Main\Loader::includeModule('alexkova.market2')
|| !\Bitrix\Main\Loader::includeModule('catalog')
)  return;

class BXReadySEOEditor extends CBitrixComponent
{
	private function addSet($arFields) {
		if (!empty($arFields) && $arFields['PRODUCT_ID']>0){

			if (is_array($arFields['DESCR'])){
				$arFields['DESCR'] = serialize($arFields['DESCR']);
			}

			$result = MS::add($arFields);

			if ($result->isSuccess())
			{
				$res = $result->getId();
				if ($res > 0 ) {
					return $res;
				}
			}
		}
		return false;
	}

	private function updateSet($id, $arFields = array())
	{
		if (!empty($arFields) && $id>0){
			MS::update($id, $arFields);
		}
	}

	private function deleteSet($id)
	{
		if ($id > 0){
			MS::delete($id);
		}
	}

	private function getSet($productId, $byId = false){

		if (intval($productId)<=0) return array();

		$result = array();
		$keyID = $byId ? 'ID' : 'PRODUCT_ID';
		$filter = array(
			$keyID =>$productId
		);

		$res = MS::getList(
			array(
				'filter'=>$filter
			)
		);
		if ($arRes = $res->fetch()){
			$arRes['DESCR'] = unserialize($arRes['DESCR']);
			if (strlen($arRes['EXT_PARAMS'])) {
				$arRes['EXT_PARAMS'] = unserialize($arRes['EXT_PARAMS']);
			}
			$arRes['CID'] = $arRes['ID'];
			$result = $arRes;
		}

		return $result;
	}

	public function checkParams()
	{

		$result = true;

		if ($this->arParams['ID'] <= 0 ) $result = false;
		$this->arParams['CROSS_TYPE'] = $this->arParams['CROSS_TYPE'] == "C" ? "C" : "F";

		if ($_SESSION['SESS_INCLUDE_AREAS']) {
			$_SESSION['SESS_INCLUDE_AREAS']=false;
		}

		if(
			$this->arParams["FILTER_NAME"] == ''
			|| !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $this->arParams["FILTER_NAME"])
		)
		{
			$this->arParams["FILTER_NAME"] = "arrFilter";
		}

		return $result;

	}

	protected function prepareAction()
	{

		if (isset($_REQUEST['action'])) {

			$action = htmlspecialcharsbx($_REQUEST['action']);
			$product = $this->arParams['ID'];
			$state = $_REQUEST['state'] == "Y" ? "Y" : "N";

			$id = intval($_REQUEST['id']);

			if ( $action == 'activate' && $id > 0) {

				$arFields = array(
					'ACTIVE' => $state,
				);
				$this->updateSet($id, $arFields);

				$useSeoSection = $state == "Y" ? true : false;
				\Alexkova\Market2\Tools::setUserField('IBLOCK_'.$this->arParams["IBLOCK_ID"].'_SECTION', $this->arParams["ID"], 'UF_BXR_SEO_SECTION', $useSeoSection);

			}

			if ( $action == 'create' && $product > 0) {

				$arFields = array(
					'PRODUCT_ID' => $product,
					'ACTIVE' => "Y",
					'DEST' => 'F'//, $this->arParams['CROSS_TYPE'],
				);
				$this->addSet($arFields);
				\Alexkova\Market2\Tools::setUserField('IBLOCK_'.$this->arParams["IBLOCK_ID"].'_SECTION', $this->arParams["ID"], 'UF_BXR_SEO_SECTION', true);
			}

			if ($action == 'update' && $id > 0) {

				if (isset($_REQUEST['id'])){

					if ($_REQUEST['ftype'] == 'F') {
						$arFields['DEST'] = 'F';
						$arFields['DESCR'] = $_REQUEST['descr'];
					} else {
						$extParams = array();
						$arFields['DEST'] = 'C';
						$obCond = new CCatalogCondTree();
						$obCond->Init(BT_COND_MODE_PARSE, BT_COND_BUILD_CATALOG, array());
						if (is_array($_REQUEST['COND_seoset']) && !empty($_REQUEST['COND_seoset'])){
							$arFields['DESCR'] = $obCond->Parse($_REQUEST['COND_seoset']);
						} else {
							$arFields['DESCR'] = \CCatalogCondTree::GetDefaultConditions();
						}
						if (isset($_REQUEST['ext_params']['filter_type'])) {
							$extParams['filter_type'] = $_REQUEST['ext_params']['filter_type'] == 'parent' ? 'parent' : 'none';
						}
					}
					if (isset($_REQUEST['ext_params']['navigation'])) {
						$extParams['navigation'] = $_REQUEST['ext_params']['navigation'] == "Y" ? true : false;
					}
					$arFields['DESCR'] = serialize($arFields['DESCR']);
					if (!empty($extParams)) {
						$arFields['EXT_PARAMS'] = serialize($extParams);
					}
					\Alexkova\Market2\Tools::setUserField('IBLOCK_'.$this->arParams["IBLOCK_ID"].'_SECTION', $this->arParams["ID"], 'UF_BXR_SEO_NAV', $extParams['navigation']);
					$this->updateSet($id, $arFields);
				}

			}

			if ( $action == 'delete' && $id > 0) {
				$this->deleteSet($id);
			}
		}
	}

	protected function getParentSection()
	{
		$res = \CIBlockSection::GetByID($this->arParams['ID']);
		if($ar_res = $res->GetNext()){
			if ($ar_res['IBLOCK_SECTION_ID'] > 0) {
				$this->arResult['PARENT_SECTION'] = $ar_res['IBLOCK_SECTION_ID'];
			}
		}
	}

	protected function prepareResult()
	{
		if (!is_array($this->arResult)) $this->arResult = array();

		$set = $this->getSet($this->arParams['ID']);

		if (!empty($set)) {
			$this->arResult['SET_INFO'] = $set;
			if ($this->arResult['SET_INFO']['DEST'] == "C" && empty($this->arResult['SET_INFO']['DESCR'])) {
				$this->arResult['SET_INFO']['DESCR'] = \CCatalogCondTree::GetDefaultConditions();
			}
			if ($this->arResult['SET_INFO']['DEST'] == "F" && !empty($this->arResult['SET_INFO']['DESCR'])) {
				$this->arResult["USE_SMART_FILTER"] = "Y";
				if (!empty($this->arResult['SET_INFO']['DESCR'])) {

					unset($_SESSION['arrFilter']);
					foreach($this->arResult['SET_INFO']['DESCR'] as $cell => $val) {
						$_GET[$this->arParams["FILTER_NAME"].$cell] = $val;
						$this->arResult['FILTER_ADD'][$cell] = $val;
					}
					$_GET['set_filter'] = 'y';
				}
			}
		}

		$this->getParentSection();

		$this->arResult['AJAX_URL'] = $this->getPath().'/ajax.php';
		if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'yes') {
			$this->arResult['AJAX_MODE'] = true;
		}

		$this->arResult['FORM_NAME'] = 'form_section_'.$this->arParams['IBLOCK_ID'].'_form';
	}


	public function executeComponent()
	{
		if (!$this->checkParams()) return;
		$this->prepareAction();

		$this->prepareResult();


		$this->includeComponentTemplate();
		\Bitrix\Main\Page\Asset::getInstance()->addJs($this->getPath()."/js/script.js");

	}
}