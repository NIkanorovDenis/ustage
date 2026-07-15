<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Alexkova\Market2\Utils\DetectMobile;

class MarketRegionController extends CBitrixComponent
{
    private $defaultRegionCode;
    private static $seoPropertiesRegion = null;
	private static $selectFields = array(
		"ID",
		"NAME",
		"CODE",
		"IBLOCK_SECTION_ID",
		"PROPERTY_BXR_GEOIP_DISTRICT",
		"PROPERTY_BXR_GEOIP_REGION",
		"PROPERTY_BXR_GEOIP_CITY",
		"PROPERTY_BXR_DOMAIN",
		"PROPERTY_BXR_YANDEX_REGION",
		"PROPERTY_BXR_GROUP_USER",
		"PROPERTY_BXR_STORE",
		"PROPERTY_BXR_LOCATION",
		"PROPERTY_BXR_SORT_PRICE_ID"
	);

    public function getSeoPropertiesRegion()
    {
        if(self::$seoPropertiesRegion != null)
            return self::$seoPropertiesRegion;
        
        $code = array();
        
        if ($this->arParams['IBLOCK_ID'] > 0) {
            $res = CIBlock::GetProperties($this->arParams['IBLOCK_ID'], array(), array());
            while($res_arr = $res->Fetch()) {
                if(strpos($res_arr["CODE"], "BXR_SEO") === 0)
                    $code[] = "PROPERTY_" . $res_arr["CODE"];
            }
        }
        
        self::$seoPropertiesRegion = $code;
        return self::$seoPropertiesRegion;
    }
    
    public function getDefaultRegionInfo()
    {
        if (empty($this->defaultRegionCode) && $this->arParams['IBLOCK_ID'] > 0) {

            $filter = array(
                "IBLOCK_ID" => $this->arParams['IBLOCK_ID'],
                "PROPERTY_DEFAULT_REGION_VALUE" => 'Y',
                "ACTIVE" => 'Y'
            );

            $select = self::$selectFields;
            
            $select = array_merge($select, self::getSeoPropertiesRegion());

            if(is_array($this->arProps['REGION_PROPERTIES'])) {
                foreach ($this->arProps['REGION_PROPERTIES'] as $val) {
                    if (!in_array('PROPERTY_' . $val, $select)) {
                        $select[] = 'PROPERTY_' . $val;
                    }
                }
            }

            $elem = \CIBlockElement::GetList(Array(),
                $filter, false, Array("nTopCount" => 1),
                $select);
            if ($result = $elem->Fetch()) {
                $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
                $marketRegistry->setRegionData(
                    array(
                        'default_region' => $result
                    )
                );

                $this->defaultRegionCode = $result["CODE"];
            }
        } else {
            $this->defaultRegionCode = 0;
        }

        return $this->defaultRegionCode;
    }

    public function getDefaultRegion()
    {
        if (empty($this->defaultRegionCode) && $this->arParams['IBLOCK_ID'] > 0) {

            $filter = array(
                "IBLOCK_ID" => $this->arParams['IBLOCK_ID'],
                "PROPERTY_DEFAULT_REGION_VALUE" => 'Y',
                "ACTIVE" => 'Y'
            );

			$select = self::$selectFields;
            
            $select = array_merge($select, self::getSeoPropertiesRegion());

            if(is_array($this->arProps['REGION_PROPERTIES'])) {
                foreach ($this->arProps['REGION_PROPERTIES'] as $val) {
                    if (!in_array('PROPERTY_' . $val, $select)) {
                        $select[] = 'PROPERTY_' . $val;
                    }
                }
            }

            $elem = \CIBlockElement::GetList(Array(),
                $filter, false, Array("nTopCount" => 1),
                $select);
            if ($result = $elem->Fetch()) {
                $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
                $marketRegistry->setRegionData(
                    array(
                        'auto_detect' => false,
                        'detect_region' => $result["CODE"],
                        'region_detail' => $result
                    )
                );

                $this->defaultRegionCode = $result["CODE"];
            }
        } else {
            $this->defaultRegionCode = 0;
        }

        return $this->defaultRegionCode;
    }

    public function getGeoIpRegion()
    {
        $ip = $_SERVER["REMOTE_ADDR"];
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://ipgeobase.ru:7020/geo?ip=' . $ip);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
        $data = curl_exec($ch);
        curl_close($ch);


        $xml = simplexml_load_string($data);

        $arXml = get_object_vars($xml->ip);
        $regionInfo = array(
            'city' => $arXml['city'],
            'region' => $arXml['region'],
            'district' => $arXml['district']
        );

        $charset = \Bitrix\Main\Application::getInstance()->getContext()->getCulture()->getCharset();
        if (strtolower($data) != 'utf-8') {
            foreach ($regionInfo as $cell => $val) {
                $regionInfo[$cell] = iconv('utf-8', $charset, $val);
            }
        }

        return $regionInfo;
    }

    public function checkRegion($regionCode)
    {
        $arFilterRegions = array(
            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
            'CODE' => $regionCode
        );

        $queryRegion = CIBlockElement::GetList(Array(), $arFilterRegions, false, false, array("ID", "CODE", "PROPERTY_BXR_DOMAIN"));
        $region = $queryRegion->GetNext();

        if (isset($region["CODE"]))
            return $region["CODE"];
        else
            return $this->getCurrentRegion();
    }

    public function setNewRegion($regionCode, $reload = false)
    {              
        global $APPLICATION;
        $regionCode = $this->checkRegion($regionCode);
        
        $this->setCoockieRegion($regionCode);
        $this->setSessionRegion($regionCode);
        if ($reload) {
            setcookie("BITRIX_SM_PK", "", -1, "/");
            LocalRedirect($APPLICATION->GetCurPageParam("", array("set_region", "region", "el1", "city", "param", "change_region"), false));
        }
    }

    public function resetRegion($reload = true)
    {
        global $APPLICATION;
        $this->setCoockieRegion("");
        $this->setSessionRegion("");
        if ($reload) {
            setcookie("BITRIX_SM_PK", "", -1, "/");
            LocalRedirect($APPLICATION->GetCurPageParam("", array("set_region", "region", "el1", "city", "param", "change_region"), false));
        }
    }
    
    public function getCurrentRegionDomain() {
        $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
        $regionData = $marketRegistry->getRegionData();
        $currentRegion = $regionData['current_region'];


        if (empty($currentRegion)) {
            $currentRegion = $this->detectRegionDomain();
        }

        $marketRegistry->setRegionData(array(
            'current_region' => $currentRegion
        ));

        return $currentRegion;
    }

    public function getCurrentRegion()
    {
        $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
        $regionData = $marketRegistry->getRegionData();
        $currentRegion = $regionData['current_region'];

        if (empty($currentRegion)) {
            $currentRegion = $this->getSessionRegion();
        }

        if (empty($currentRegion))
            $currentRegion = $this->getCoockieRegion();

        $marketRegistry->setRegionData(array(
            'current_region' => $currentRegion
        ));
        
        return $currentRegion;
    }
    
    public function detectRegionDomain()
    {
        return $this->getRegionInfoDomain();
    }

    public function detectRegion()
    {
        $regionId = $this->getRegionIdByInfo($this->getGeoIpRegion());
        
        $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
        $marketRegistry->setRegionData(
            array(
                'use_geoip' => true,
            )
        );

        return $regionId;
    }

    public function getRegionIdByInfo($regionInfo)
    {
        
        $filter = array(
            "IBLOCK_ID" => $this->arParams['IBLOCK_ID'],
            "ACTIVE" => 'Y',
            array(
                'LOGIC' => 'OR',
                "PROPERTY_BXR_GEOIP_DISTRICT" => $regionInfo['district'],
                "PROPERTY_BXR_GEOIP_REGION" => $regionInfo['region'],
                "PROPERTY_BXR_GEOIP_CITY" => $regionInfo['city']
            )
        );

		$select = self::$selectFields;
        
        $select = array_merge($select, self::getSeoPropertiesRegion());

        if(is_array($this->arProps['REGION_PROPERTIES'])) {
            foreach ($this->arProps['REGION_PROPERTIES'] as $val) {
                if (!in_array('PROPERTY_' . $val, $select)) {
                    $select[] = 'PROPERTY_' . $val;
                }
            }
        }

        $elements = \CIBlockElement::GetList(array('sort' => 'asc'), $filter, false, false, $select);
        $arElement = array();
        while($elem = $elements->Fetch()) {

            if(!isset($arElement[$elem["PROPERTY_BXR_GEOIP_CITY_VALUE"]])) {
                $arElement[$elem["PROPERTY_BXR_GEOIP_CITY_VALUE"]] = array(
                    'auto_detect' => true,
                    'detect_region' => $elem['CODE'],
                    'region_detail' => $elem
                );
            }
            
            if(!isset($arElement[$elem["PROPERTY_BXR_GEOIP_REGION_VALUE"]])) {
                $arElement[$elem["PROPERTY_BXR_GEOIP_REGION_VALUE"]] = array(
                    'auto_detect' => true,
                    'detect_region' => $elem['CODE'],
                    'region_detail' => $elem
                );
            }
            
            if(!isset($arElement[$elem["PROPERTY_BXR_GEOIP_DISTRICT_VALUE"]])) {
                $arElement[$elem["PROPERTY_BXR_GEOIP_DISTRICT_VALUE"]] = array(
                    'auto_detect' => true,
                    'detect_region' => $elem['CODE'],
                    'region_detail' => $elem
                );
            }
        };
        
        if(isset($arElement[$regionInfo['city']])) {
            $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
            
            $marketRegistry->setRegionData(
                array(
                    'auto_detect' => true,
                    'detect_region' => $arElement[$regionInfo['city']]['CODE'],
                    'region_detail' => $arElement[$regionInfo['city']]
                )
            );
            return $arElement[$regionInfo['city']]['detect_region'];
        }
        
        if(isset($arElement[$regionInfo['region']])) {
            $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
            $marketRegistry->setRegionData(
                array(
                    'auto_detect' => true,
                    'detect_region' => $arElement[$regionInfo['region']]['CODE'],
                    'region_detail' => $arElement[$regionInfo['region']]
                )
            );
            return $arElement[$regionInfo['region']]['detect_region'];
        }
        
        if(isset($arElement[$regionInfo['district']])) {
            $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
            $marketRegistry->setRegionData(
                array(
                    'auto_detect' => true,
                    'detect_region' => $arElement[$regionInfo['district']]['CODE'],
                    'region_detail' => $arElement[$regionInfo['district']]
                )
            );
            return $arElement[$regionInfo['district']]['detect_region'];
        }
        
            
        return 0;
    }
    
    public function getRegionInfoDomain()
    {
        $iblock = $this->arParams['IBLOCK_ID'];

        if (intval($iblock) <= 0)
            return array();
        
        $filter = array("IBLOCK_ID" => $iblock, "PROPERTY_BXR_DOMAIN" => $_SERVER['HTTP_HOST']);

		$select = self::$selectFields;
        $select = array_merge($select, self::getSeoPropertiesRegion());

        if (is_array($this->arProps['REGION_PROPERTIES'])) {
            foreach ($this->arProps['REGION_PROPERTIES'] as $val) {
                if (!in_array('PROPERTY_' . $val, $select)) {
                    $select[] = 'PROPERTY_' . $val;
                }
            }
        }

        $elements = \CIBlockElement::GetList(array(), $filter, false, false, $select);
        if ($elem = $elements->Fetch()) {
            $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
            $currentData = $marketRegistry->getRegionData();

            $marketRegistry->setRegionData(
                array(
                    'auto_detect' => $currentData['auto_detect'] ? true : false,
                    'restore_info' => $currentData['auto_detect'] ? false : true,
                    'detect_region' => $elem["CODE"],
                    'region_detail' => $elem
                )
            );
        }

        return $elem["CODE"];
    }

    public function getRegionInfo($regionCode)
    {
        $iblock = $this->arParams['IBLOCK_ID'];

        if (empty($regionCode) || intval($iblock) <= 0)
            return array();

        $filter = array("IBLOCK_ID" => $iblock, "CODE" => $regionCode);
		$select = self::$selectFields;
        
        $select = array_merge($select, self::getSeoPropertiesRegion());

        if (is_array($this->arProps['REGION_PROPERTIES'])) {
            foreach ($this->arProps['REGION_PROPERTIES'] as $val) {
                if (!in_array('PROPERTY_' . $val, $select)) {
                    $select[] = 'PROPERTY_' . $val;
                }
            }
        }

        $elements = \CIBlockElement::GetList(array(), $filter, false, false, $select);
        if ($elem = $elements->Fetch()) {
            $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
            $currentData = $marketRegistry->getRegionData();

            $marketRegistry->setRegionData(
                array(
                    'auto_detect' => $currentData['auto_detect'] ? true : false,
                    'restore_info' => $currentData['auto_detect'] ? false : true,
                    'detect_region' => $elem["CODE"],
                    'region_detail' => $elem
                )
            );
        }

        return $elem["CODE"];
    }

    public function setCoockieRegion($regionCode)
    {
        global $APPLICATION;
        $APPLICATION->set_cookie("REGION", $regionCode, time() + 60 * 60 * 24 * 2);

		$mb = "";
		if (DetectMobile::isMobileDevice()){
            $mb = 'mbl_';
        }
        
        if(!empty($regionCode)) {
            $_COOKIE["BITRIX_SM_PK"] = $mb."page_" . $regionCode;
            setcookie("BITRIX_SM_PK", $mb."page_" . $regionCode, time() + 60 * 60 * 24 * 2, "/");
            $APPLICATION->set_cookie("PK", $mb."page_" . $regionCode, time() + 60 * 60 * 24 * 2);
        }
    }

    public function getCoockieRegion()
    {
        global $APPLICATION;
        $regionCode = $APPLICATION->get_cookie("REGION");

        return $regionCode;
    }

    public static function setSessionRegion($regionCode)
    {
        $_SESSION["REGION"] = $regionCode;
        
        $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
        $regionData = $marketRegistry->getRegionData();
        
        if(isset($regionData["region_detail"]) && !empty($regionData["region_detail"])) {
            $_SESSION["REGION_INFO"] = serialize($regionData);
        }

		$mb = "";
		if (DetectMobile::isMobileDevice()){
            $mb = 'mbl_';
        }
        
        if(!empty($regionCode))
            $_SESSION["PK"] = $mb."page_" . $regionCode;
    }

    public static function getSessionRegion()
    {
        $regionCode = $_SESSION["REGION"];
        return $regionCode;
    }
}