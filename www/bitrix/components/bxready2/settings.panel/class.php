<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Application,
	Alexkova\Bxready2\Settings as PS,
	Bitrix\Main\Web\Uri;

Loc::loadMessages(__FILE__);

if (
!\Bitrix\Main\Loader::includeModule('alexkova.bxready2')
)  return;

class BXReady2SettingsPanel extends CBitrixComponent
{
	private $settings = array();

	public function checkParams()
	{
		$result = true;
		if (!isset($this->arParams['TYPE'])) {
			$this->arParams['TYPE'] = 'A';
		}
		global $USER;
		if ($this->arParams['TYPE'] == 'A' && !$USER->IsAdmin()) {
			return false;
		} else {
			if (!\Alexkova\Bxready2\Bxready::getInstance()->useAdminSettings()) {
				return false;
			};
		}
		return $result;
	}

	protected function getSettings()
	{
		if (empty($this->settings)) {
			if ($this->arParams['TYPE'] == 'A') {
				$this->settings = PS::getPanelSettings(SITE_TEMPLATE_ID);
			} else {
				$this->settings = PS::getPanelSettings(SITE_TEMPLATE_ID, true, \Alexkova\Bxready2\Bxready::getInstance()->getUser());
			}
		}
	}

	protected function prepareAction()
	{
		$useMixin = true;
		$userConf = $this->arParams['TYPE'] == 'A' ? false : true;
		$this->arResult['AJAX_MODE'] = $this->arParams['FROM_AJAX'] ? true : false;

                if (isset($_REQUEST["svisual_id"]) && intval($_REQUEST["svisual_id"])>0){
				
                    $this->settings['selected'] = \Alexkova\Bxready2\Settings::getUserSettings(intval($_REQUEST["svisual_id"]));

                    PS::savePanelSettings(SITE_TEMPLATE_ID, $this->settings, true);
                    
                    $conf = PS::mixinConfiguration(SITE_TEMPLATE_ID, $userConf, \Alexkova\Bxready2\Bxready::getInstance()->getUser());
                    PS::saveConfiguration(SITE_TEMPLATE_ID, $conf, $userConf);
                    
                    global $APPLICATION;
                    $newPage = $APPLICATION->GetCurPageParam("", array("svisual_id"));
                    LocalRedirect($newPage);
                }
                
		if (isset($_REQUEST['action'])) {

			$this->getSettings();
			switch($_REQUEST['action']) {
				case 'lazy':
					$this->arResult['LAZY'] = true;
					$useMixin = false;
					break;

				case 'reset':
					$this->settings['selected'] = !empty($this->settings['default']['default']) ? $this->settings['default']['default'] : array() ;
					PS::savePanelSettings(SITE_TEMPLATE_ID, $this->settings, $userConf);
					break;

				case 'set':
					if (isset($_REQUEST['selected']) && is_array($_REQUEST['selected'])) {
						foreach($_REQUEST['selected'] as $cell=>$val) {
							$this->settings['selected'][htmlspecialchars($cell)] = htmlspecialchars($val);
						}
					}
					PS::savePanelSettings(SITE_TEMPLATE_ID, $this->settings, $userConf);
					break;
			}
			if (isset($_REQUEST['tab'])) {
				$this->arResult['TAB'] = htmlspecialchars($_REQUEST['tab']);
				$_SESSION['TAB'] = htmlspecialchars($_REQUEST['tab']);
			}

			if ($useMixin) {
				$conf = PS::mixinConfiguration(SITE_TEMPLATE_ID, $userConf, \Alexkova\Bxready2\Bxready::getInstance()->getUser());
				PS::saveConfiguration(SITE_TEMPLATE_ID, $conf, $userConf);

			}

		} else {
			if (isset($_SESSION['TAB'])) {
				$this->arResult['TAB'] = $_SESSION['TAB'];
				$this->arResult['SHOW'] = true;
				unset($_SESSION['TAB']);
			}
		}
	}

	protected function prepareResult()
	{
		$arResult = &$this->arResult;
		$this->getSettings();
		$arResult['settings'] = $this->settings['settings'];
		$arResult['parents'] = $this->settings['parents'];
		$arResult['selected'] = $this->settings['selected'];

	}


	public function executeComponent()
	{
		if (!$this->checkParams()) return;
		$this->prepareAction();
		$this->prepareResult();
		\Bitrix\Main\Page\Asset::getInstance()->addCss('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext');
		$this->includeComponentTemplate();
	}
}