<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Type;
use \Bitrix\Main\Entity;

if(!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("ASKARON_REVIEWS_IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}

if(!CModule::IncludeModule("askaron.reviews"))
{
	ShowError(GetMessage("ASKARON_REVIEWS_MODULE_NOT_INSTALLED"));
	return;
}

$arParams["ELEMENT_ID"] = intval($arParams["ELEMENT_ID"]);
//$arParams["CURRENT_USER"] != "Y" ? "N": "Y";

if(!isset($arParams["CACHE_TIME"]))
{
	$arParams["CACHE_TIME"] = 86400;
}

$arParams["PAGE_ELEMENT_COUNT"] = intval( $arParams["PAGE_ELEMENT_COUNT"] );

//if ( $arParams["PAGE_ELEMENT_COUNT"] <= 0 )
//{
//	$arParams["PAGE_ELEMENT_COUNT"] = intval( COption::GetOptionString( "askaron.reviews", "list_count" ) );
//}

if ( $arParams["PAGE_ELEMENT_COUNT"] <= 0 )
{
	$arParams["PAGE_ELEMENT_COUNT"] = 30;
}

$arParams["PAGER_TEMPLATE"] = trim($arParams["PAGER_TEMPLATE"]);
$arParams["DISPLAY_BOTTOM_PAGER"] = $arParams["DISPLAY_BOTTOM_PAGER"]!="N";

$arNavigation = false;
$arParams["PAGE_NUMBER"] = 0;

if ( $arParams["DISPLAY_BOTTOM_PAGER"] )
{
	// first page without PAGEN and $arResult["bSavePage"] == false
	CPageOption::SetOptionString("main", "nav_page_in_session", "N");

	$arNavParams = array(
		"nPageSize" => $arParams["PAGE_ELEMENT_COUNT"],
		"bDescPageNumbering" => true,
		"bShowAll" => false,
	);

	$arNavigation = CDBResult::GetNavParams($arNavParams); // hidden PAGEN ++ and $_GET["PAGEN_i"]	
	$arParams["PAGE_NUMBER"] = intval( $arNavigation["PAGEN"] );
}

if($arParams["CACHE_TYPE"] == "N" || ($arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N") )
{
	$arParams["CACHE_TIME"] = 0;
}

$arParams["MODULE_RIGHT"] = $APPLICATION->GetGroupRight( "askaron.reviews" );

if ( $arParams["ELEMENT_ID"] > 0 )
{	
	if ( $arParams["MODULE_RIGHT"] >= "W" )
	{
		if ( strlen( $_REQUEST["reviews_action"] ) > 0 && check_bitrix_sessid() )
		{
			$id = intval( $_REQUEST["reviews_id"] );
			if ( $id > 0 )
			{
				// check if exists
				$arReview = \Askaron\Reviews\ReviewTable::getList(array(
					"filter" => array(
						"=ID" => $id,
						"=ELEMENT_ID" => $arParams["ELEMENT_ID"]
					),
					'select' => array('ID'),
					'limit' => 1,
				))->fetch();

				if ($arReview)
				{
					$result = false;

					if ( $_REQUEST["reviews_action"] == "show" )
					{
						$result = \Askaron\Reviews\ReviewTable::update( $id, array( "ACTIVE" => "Y" ) );
					}

					if ( $_REQUEST["reviews_action"] == "hide" )
					{
						$result = \Askaron\Reviews\ReviewTable::update( $id, array( "ACTIVE" => "N" ) );
					}

					if ( $_REQUEST["reviews_action"] == "delete" )
					{
						$result = \Askaron\Reviews\ReviewTable::delete( $id );
					}

					if ( is_object( $result ) )
					{
						if ( $result->isSuccess() )
						{
							$url = $url = $APPLICATION->GetCurPageParam("", array("reviews_id", "reviews_action", "sessid"));
							LocalRedirect( $url );
						}
					}
				}				
			}
		}
	}

	if( $this->StartResultCache(  false, array( $arNavigation ) ) )
	{
		if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER']))
		{
			$GLOBALS['CACHE_MANAGER']->StartTagCache($this->__cachePath);			
			$GLOBALS['CACHE_MANAGER']->RegisterTag( 'askaron_reviews' ); // all module cache			
			$GLOBALS['CACHE_MANAGER']->RegisterTag( 'askaron_reviews_for_element_'.$arParams["ELEMENT_ID"] ); // cache by element
			$GLOBALS['CACHE_MANAGER']->EndTagCache();
		}
		
		$arResult = array(
			"ELEMENT" => array(),
			"TOTAL_COUNT" => 0, // total elements
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"PAGES_COUNT" => 0, // total pages
			"PAGE_NUMBER" => 0, // current page. 0 or more
			"NAV_STRING" => "",			
			"ITEMS" => array(),
			"NAV_PARAMS" => null,
			"NAV_NUM" => 0,
		);

		$arFilter = array(
			"ID" => $arParams["ELEMENT_ID"]
		);

		$arSelect = array(
			"ID",
			"ACTIVE",
			"IBLOCK_ID",
			"NAME",
//			"CODE",
//			"DETAIL_PAGE_URL"
		);


		$res = \CIBlockElement::GetList( array(), $arFilter, false, false, $arSelect);
		if ( $arFields = $res->GetNext() )
		{
			$arResult["ELEMENT"] = 	$arFields;
		}

		$arFilter = array(
			"=ELEMENT_ID" => $arParams["ELEMENT_ID"],
		);
		
		if ( $arParams["MODULE_RIGHT"] < "R" )
		{
			$arFilter["ACTIVE"] = "Y";
		}
		
		// get Count			
		$arCount = \Askaron\Reviews\ReviewTable::getList(array(
			"filter" => $arFilter,
			'select' => array('CNT'),
			'runtime' => array(
				new Entity\ExpressionField( 'CNT', 'COUNT(*)' )
			)
		))->fetch();
		
		$arResult["TOTAL_COUNT"] = $arCount["CNT"];		
		$arResult["PAGES_COUNT"] = floor( $arResult["TOTAL_COUNT"] / $arResult["PAGE_ELEMENT_COUNT"]);
		$arResult["PAGES_COUNT"] = max( $arResult["PAGES_COUNT"], 1 );
		
		if ( $arParams["PAGE_NUMBER"] < $arResult["PAGES_COUNT"] )
		{
			$arResult["PAGE_NUMBER"] = $arParams["PAGE_NUMBER"];
			
			
			// get Items
			$arParameters = array(
				'order' => array('DATE' => 'DESC'),
				"filter" => $arFilter,
				'select' => array(
					"*",
					"AUTHOR_USER.NAME",
					"AUTHOR_USER.LAST_NAME",
					"AUTHOR_USER.LOGIN",
//					"ELEMENT.ID",
//					"ELEMENT.IBLOCK_ID",
//					"ELEMENT.NAME"
				),
			);

			if ( $arParams["DISPLAY_BOTTOM_PAGER"] )
			{
				if ( $arResult["PAGE_NUMBER"] > 0 )
				{
					$arParameters['limit'] = $arResult["PAGE_ELEMENT_COUNT"];
					$arParameters['offset'] = $arResult["TOTAL_COUNT"] - $arResult["PAGE_ELEMENT_COUNT"] * ( $arResult["PAGE_NUMBER"] );
				}
				else
				{
					$arParameters['limit'] = $arResult["PAGE_ELEMENT_COUNT"] * 2 -1;
					$arParameters['offset'] = 0;
				}
			}
			else
			{
				$arParameters['limit'] = $arResult["PAGE_ELEMENT_COUNT"];
				$arParameters['offset'] = 0;
			}
			
			$res = \Askaron\Reviews\ReviewTable::getList( $arParameters );
			
			while ( $arFields = $res->fetch() )
			{			
				$arFieldsNext = array();

				foreach ( $arFields as $key => $value )
				{
					$arFieldsNext["~".$key] = $value;

					$arFieldsNext[$key] = htmlspecialcharsbx( $value );

					if ( $value instanceof Type\DateTime )
					{
						$arFieldsNext[ "~".$key."_SHORT" ] = $value->format( Type\Date::getFormat() );
						$arFieldsNext[ $key."_SHORT" ] = htmlspecialcharsbx( $arFieldsNext[ "~".$key."_SHORT" ] );
					}

					if ( $key == "PRO" ||  $key == "CONTRA" ||  $key == "TEXT" )
					{
						$arFieldsNext[$key] = str_replace( "\n", "<br>", $arFieldsNext[$key] );
					}
				}


				$display_name = trim( $arFieldsNext["~AUTHOR_NAME"] );

				if ($display_name == "")
				{
					$display_name = trim($arFieldsNext["~ASKARON_REVIEWS_REVIEW_AUTHOR_USER_NAME"]." ".$arFieldsNext["~ASKARON_REVIEWS_REVIEW_AUTHOR_USER_LAST_NAME"] );
				}

				if ($display_name == "")
				{
					if ( $arFieldsNext["AUTHOR_USER_ID"] > 0 )
					{
						$display_name = GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_USER").$arFieldsNext["AUTHOR_USER_ID"];
					}
					else
					{
						$display_name = GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_GUEST");
					}
				}

				$arFieldsNext["~DISPLAY_NAME"] = $display_name;
				$arFieldsNext["DISPLAY_NAME"] = htmlspecialcharsbx($display_name);
				
				$arFieldsNext["GRADE_TEXT"] = "";
				
				if ( $arFieldsNext["GRADE"] == 1 )
				{
					$arFieldsNext["GRADE_TEXT"] = GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_TERRIBLE_MODEL");
				}

				if ( $arFieldsNext["GRADE"] == 2 )
				{
					$arFieldsNext["GRADE_TEXT"] = GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_BAD_MODEL");
				}

				if ( $arFieldsNext["GRADE"] == 3 )
				{
					$arFieldsNext["GRADE_TEXT"] = GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_USUAL_MODEL");
				}

				if ( $arFieldsNext["GRADE"] == 4 )
				{
					$arFieldsNext["GRADE_TEXT"] = GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_GOOD_MODEL");
				}

				if ( $arFieldsNext["GRADE"] == 5 )
				{
					$arFieldsNext["GRADE_TEXT"] = GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_EXCELLENT_MODELQ");
				}
				
				
				$arResult["ITEMS"][] = $arFieldsNext;
			}
		}
		else
		{
			$this->AbortResultCache();
			
			// no this page number. Go to 0 page			
			//$url = $APPLICATION->GetCurPageParam("", array( "PAGEN_1" ) );
			//LocalRedirect( $url );
		}

		$this->EndResultCache();
	}
	
	
	
	
	foreach ( $arResult["ITEMS"] as $key => $arItem )
	{
		$arUrl = array(
			"HIDE" => "",
			"SHOW" => "",
			"DELETE" => "",
			"EDIT" => "",
		);
		
	
		if ( $arParams["MODULE_RIGHT"] >= "W" )
		{
			$url = $APPLICATION->GetCurPageParam("reviews_id=".$arItem["ID"]."&reviews_action=show&".bitrix_sessid_get(), array("reviews_id", "reviews_action", "sessid"));
			$arUrl["SHOW"] = '<a href="'.$url.'">'.GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_PUBLIC").'</a>';

			$url = $APPLICATION->GetCurPageParam("reviews_id=".$arItem["ID"]."&reviews_action=hide&".bitrix_sessid_get(), array("reviews_id", "reviews_action", "sessid"));
			$arUrl["HIDE"] = '<a href="'.$url.'">'.GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_HIDE").'</a>';

			$arUrl["EDIT"] = '<a href="/bitrix/admin/perfmon_row_edit.php?lang='.LANGUAGE_ID.'&table_name=b_askaron_reviews_review&pk[ID]='.$arItem["ID"].'" target="_blank">'.GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_EDIT").'</a>';

			$url = $APPLICATION->GetCurPageParam("reviews_id=".$arItem["ID"]."&reviews_action=delete&".bitrix_sessid_get(), array("reviews_id", "reviews_action", "sessid"));
			$arUrl["DELETE"] = '<a onclick="if ( confirm( \''.GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_DELETE_CONFIRM").'\' ) ) { this.nextSibling.click(); }" href="javascript: void(0);">'.GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_DELETE").'</a><a style="display:none;" href="'.$url.'"></a>';
		}
	
		$arResult["ITEMS"][ $key ][ "URL" ] = $arUrl;
	}
	
	if ( $arResult["PAGES_COUNT"] > 1 )
	{
		$result = new CDBResult();

		$result->NavStart( $arResult["PAGE_ELEMENT_COUNT"], false, $arResult["PAGE_NUMBER"] ); // get PAGEN and SIZEN
		$result->NavRecordCount = $arResult["TOTAL_COUNT"];
		$result->NavPageSize = $arResult["PAGE_ELEMENT_COUNT"];
		$result->NavPageCount = $arResult["PAGES_COUNT"];

		if ( $arResult["PAGE_NUMBER"] > 0 )
		{
			$result->NavPageNomer = $arResult["PAGE_NUMBER"];	
		}
		else
		{
			$result->NavPageNomer = $arResult["PAGES_COUNT"];
		}
		$result->bDescPageNumbering = true;	

		$arResult["NAV_STRING"] = $result->GetPageNavStringEx($navComponentObject, GetMessage("ASKARON_REVIEWS_PAGER_TITLE"), $arParams["PAGER_TEMPLATE"], false);
		$arResult["NAV_PARAMS"] = $result->GetNavParams();	
		$arResult["NAV_NUM"] = $result->NavNum;
	}		

	//CAjax::Init();	
	$this->IncludeComponentTemplate();
}
else
{
	ShowError(GetMessage("ASKARON_REVIEWS_ELEMENT_NO_ID"));
}

//d( $arResult );
?>
