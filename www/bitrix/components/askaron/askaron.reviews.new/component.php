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

//if(!isset($arParams["CACHE_TIME"]))
//{
//	$arParams["CACHE_TIME"] = 86400;
//}

//if($arParams["CACHE_TYPE"] == "N" || ($arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N") )
//{
//	$arParams["CACHE_TIME"] = 0;
//}

//$arParams["MODULE_RIGHT"] = $APPLICATION->GetGroupRight( "askaron.reviews" );

$arResult = array(
	"NEW_ADDED" => false,
	"NEW_ADDED_TEXT" => GetMessage("ASKARON_REVIEWS_REVIEW_ADDED_MESSAGE"),
	"NEW_ADDED_PREMODERATE_TEXT" => GetMessage("ASKARON_REVIEWS_REVIEW_NEED_MODERATE_MESSAGE"),
	"MODULE_RIGHT" => $APPLICATION->GetGroupRight( "askaron.reviews" ),
	"PREMODERATE" => ( COption::GetOptionString("askaron.reviews", "premoderate") == "Y" ) && ( $APPLICATION->GetGroupRight( "askaron.reviews" ) <= "R" ),
	"USE_CAPTCHA" => ( COption::GetOptionString("askaron.reviews", "use_captcha") == "Y" ) && !$USER->IsAuthorized(),
	//"OK_MESSAGE" => "",
	"ERRORS" => array(),
	"FIELDS" => array(
		"GRADE" => array(
			"NAME" => GetMessage("ASKARON_REVIEWS_FORM_GRADE"),
			"VALUE" => "",
			"~VALUE" => "",
		),		
		"PRO" => array(
			"NAME" => GetMessage("ASKARON_REVIEWS_FORM_PRO"),
			"VALUE" => "",
			"~VALUE" => "",
		),
		"CONTRA" => array(
			"NAME" => GetMessage("ASKARON_REVIEWS_FORM_CONTRA"),
			"VALUE" => "",
			"~VALUE" => "",
		),
		"TEXT" => array(
			"NAME" => GetMessage("ASKARON_REVIEWS_FORM_TEXT"),
			"VALUE" => "",
			"~VALUE" => "",
		),
		"AUTHOR_NAME" => array(
			"NAME" => GetMessage("ASKARON_REVIEWS_FORM_NAME"),
			"VALUE" => "",
			"~VALUE" => "",
		),
		"AUTHOR_EMAIL" => array(
			"NAME" => "E-mail",
			"VALUE" => "",
			"~VALUE" => "",
		),		
	),
);


if ( $arParams["ELEMENT_ID"] > 0 )
{
	if ( $USER->IsAuthorized() )
	{
		unset( $arResult["FIELDS"]["AUTHOR_NAME"] );
		unset( $arResult["FIELDS"]["AUTHOR_EMAIL"] );
	}	
	
	if ( isset( $_REQUEST["new_review_form"] ) && $_REQUEST["new_review_form"] == "Y" )
	{
		foreach ( $arResult["FIELDS"] as $key => $arField )
		{
			if ( isset( $_REQUEST["new_review"][$key] ) )
			{
				$arResult["FIELDS"][ $key ][ "~VALUE" ] = $_REQUEST["new_review"][$key];
				$arResult["FIELDS"][ $key ][ "VALUE" ] = htmlspecialcharsbx( $arResult["FIELDS"][ $key ][ "~VALUE" ] );
			}
		}
		
		if ( check_bitrix_sessid() )
		{
			// check fields
			foreach ( $arResult["FIELDS"] as $key => $arField )
			{
				if ( strlen( $arField["VALUE"] ) == 0 )
				{
					$arResult["ERRORS"]["FIELD_EMPTY_".$key] = GetMessage("ASKARON_REVIEWS_FIELD")." «".$arField["NAME"]."» ".GetMessage("ASKARON_REVIEWS_IS_EMPTY");
				}
				else
				{
					if ( $key == "GRADE" && !in_array( $arField["~VALUE"], array(1,2,3,4,5) ) )
					{
						$arResult["ERRORS"]["FIELD_EMPTY_".$key] = GetMessage("ASKARON_REVIEWS_WRONG_GRADE");
					}
					
					if ( $key == "AUTHOR_EMAIL" && !check_email( $arField["~VALUE"] ) )
					{
						$arResult["ERRORS"]["FIELD_EMPTY_".$key] = GetMessage("ASKARON_REVIEWS_WRONG_EMAIL");
					}					
				}
			}
			
			// get iblock element
			$arIblockElement = CIblockElement::GetList( 
					array(),
					array( "ID" => $arParams["ELEMENT_ID"] ),
					false,
					array( "nTopCount" => 1 ),
					array( "ID", "NAME", "IBLOCK_ID", "DETAIL_PAGE_URL" )
			)->GetNext();
			
			//d($arIblockElement);
			
			if ( !$arIblockElement )
			{
				$arResult["ERRORS"]["ELEMENT_NOT_FOUND"] = GetMessage( "ASKARON_REVIEWS_NEW_ELEMENT_NOT_FOUND" );
			}
			
			// Check CAPTCHA
			if( $arResult["USE_CAPTCHA"] )
			{
				if (strlen($_POST["captcha_word"])>0)
				{
					include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");

					$cpt = new CCaptcha();
					if (strlen($_POST["captcha_code"]) > 0)
					{						
						$captchaPass = COption::GetOptionString("main", "captcha_password", "");
						
						if (!$cpt->CheckCodeCrypt($_POST["captcha_word"], $_POST["captcha_code"], $captchaPass))
						{
							$arResult["ERRORS"]["CAPTCHA_IS_BAD"] = GetMessage( "ASKARON_REVIEWS_NEW_CAPTCHA_IS_BAD" );
						}
					}
				}
				else 
				{
					$arResult["ERRORS"]["EMPTY_CAPTCHA"] = GetMessage( "ASKARON_REVIEWS_NEW_EMPTY_CAPTCHA" );
				}
			}			
			
			if ( !$arResult["ERRORS"] )
			{
				// add new element
				$arAddFields = array(
					"ELEMENT_ID" => $arParams["ELEMENT_ID"],															
				);
				
				if ( $arResult["PREMODERATE"] )
				{
					$arAddFields["ACTIVE"] = "N";
				}
				
				foreach ( $arResult["FIELDS"] as $key => $arField )
				{
					$arAddFields[ $key ] = $arField["~VALUE"];
				}
				
				if ( $USER->IsAuthorized() )
				{
					$arAddFields["AUTHOR_USER_ID"] = $USER->GetId();
				}
				
				$arAddFields["AUTHOR_IP"] = trim($_SERVER["REMOTE_ADDR"]);				
				
				if ( isset( $_SESSION["SESS_SESSION_ID"] ) )
				{
					$arAddFields["AUTHOR_STAT_SESSION_ID"] = intval( $_SESSION["SESS_SESSION_ID"] );
				}
				
				$result = \Askaron\Reviews\ReviewTable::add( $arAddFields );
				
				if ($result->isSuccess())
				{
					//$id = $result->getId();
					$arResult["NEW_ADDED"] = true;
				}
				
				// send message
				$arFilter = array(
					"=ID" => $result->getId(),
				);

				$arParameters = array(
					'order' => array('DATE' => 'DESC'),
					"filter" => $arFilter,
					'select' => array(
						"*",
						"AUTHOR_USER.EMAIL",
						"AUTHOR_USER.NAME",
						"AUTHOR_USER.LAST_NAME",
						"AUTHOR_USER.LOGIN",
//					"ELEMENT.ID",
//					"ELEMENT.IBLOCK_ID",
//					"ELEMENT.NAME"
					),
				);

				$arAddedFields = \Askaron\Reviews\ReviewTable::getList( $arParameters )->fetch();
				if ( $arAddedFields )
				{
					$arMessageFields = array( );
					
					foreach ( $arAddedFields as $key => $value )
					{
						$arMessageFields[ $key ] = $value;
					}					
					
					$arMessageFields[ "PRODUCT_PAGE_URL" ] = $arIblockElement["DETAIL_PAGE_URL"];
					$arMessageFields[ "PRODUCT_NAME" ] = $arIblockElement["~NAME"];
					
					$arMessageFields[ "SUBJECT" ] = $_SERVER["SERVER_NAME"].": ".GetMessage("ASKARON_REVIEWS_MESSAGE_NEW_REVIEW1");
					
					if ( strlen( COption::GetOptionString( "askaron.reviews", "email" ) ) > 0 )
					{
						$arMessageFields[ "EMAIL_TO" ] = COption::GetOptionString( "askaron.reviews", "email" );
					}
					else
					{
						$arMessageFields[ "EMAIL_TO" ] = COption::GetOptionString("main", "email_from", "admin@".$_SERVER["SERVER_NAME"]);
					}
					
					$arMessageFields[ "REQUEST_URI" ] = $_SERVER["REQUEST_URI"];
					
					$arMessageFields[ "MESSAGE" ] = "";
					$arMessageFields[ "MESSAGE" ] .= GetMessage("ASKARON_REVIEWS_MESSAGE_NEW_REVIEW2").": ".$arMessageFields[ "PRODUCT_NAME" ]."\n";
					$arMessageFields[ "MESSAGE" ] .= "http://".$_SERVER["SERVER_NAME"].$arMessageFields[ "PRODUCT_PAGE_URL" ]."\n\n";

					// User: [1] admin (Artemy Zaitsev)
					$arMessageFields[ "MESSAGE" ] .= GetMessage("ASKARON_REVIEWS_MESSAGE_USER").": ";

					if ( strlen( $arAddedFields["ASKARON_REVIEWS_REVIEW_AUTHOR_USER_LOGIN"] ) > 0 )
					{
						$strUser = "[".$arAddedFields["AUTHOR_USER_ID"]."] ".$arAddedFields["ASKARON_REVIEWS_REVIEW_AUTHOR_USER_LOGIN"];

						$strUserName = trim($arAddedFields["ASKARON_REVIEWS_REVIEW_AUTHOR_USER_NAME"]." ".$arAddedFields["ASKARON_REVIEWS_REVIEW_AUTHOR_USER_LAST_NAME"]);

						if (strlen( $strUserName ) > 0)
						{
							$strUser .= " (".$strUserName.")";
						}

						$arMessageFields[ "MESSAGE" ] .= $strUser;
					}
					else
					{
						$arMessageFields[ "MESSAGE" ] .= GetMessage("ASKARON_REVIEWS_MESSAGE_USER_GUEST");
					}

					$arMessageFields[ "MESSAGE" ] .= "\n\n";

					// Form fields
					foreach ( $arResult["FIELDS"] as $key => $arField )
					{
						$arMessageFields[ "MESSAGE" ] .= $arResult["FIELDS"][$key]["NAME"]."\n";
						$arMessageFields[ "MESSAGE" ] .= $arMessageFields[$key]."\n\n";
					}

//					$arMessageFields[ "MESSAGE" ] .= $arResult["FIELDS"]["GRADE"]["NAME"]."\n";
//					$arMessageFields[ "MESSAGE" ] .= $arMessageFields[ "GRADE" ]."\n\n";
//
//					$arMessageFields[ "MESSAGE" ] .= $arResult["FIELDS"]["PRO"]["NAME"]."\n";
//					$arMessageFields[ "MESSAGE" ] .= $arMessageFields[ "PRO" ]."\n\n";
//
//					$arMessageFields[ "MESSAGE" ] .= $arResult["FIELDS"]["CONTRA"]["NAME"]."\n";
//					$arMessageFields[ "MESSAGE" ] .= $arMessageFields[ "CONTRA" ]."\n\n";
//
//					$arMessageFields[ "MESSAGE" ] .= $arResult["FIELDS"]["TEXT"]["NAME"]."\n";
//					$arMessageFields[ "MESSAGE" ] .= $arMessageFields[ "TEXT" ]."\n\n";

					$arMessageFields[ "MESSAGE" ] .= "-------------------------------\n";
					$arMessageFields[ "MESSAGE" ] .= GetMessage("ASKARON_REVIEWS_MESSAGE_AUTOMATIC")."\n\n";
					$arMessageFields[ "MESSAGE" ] .= GetMessage("ASKARON_REVIEWS_MESSAGE_PAGE")." http://".$_SERVER["SERVER_NAME"].$APPLICATION->GetCurPageParam("", array( "bxajaxid" ) );

					
					CEvent::Send("ASKARON_REVIEWS_NEW_REVIEW", SITE_ID, $arMessageFields);
				}
				
				// Redirect
				$url = $APPLICATION->GetCurPageParam( "new_review_added=Y", array("new_review_added") );
				LocalRedirect($url);
			}
		}
		else
		{
			$arResult["ERRORS"]["SESSION_EXPIRED"] = GetMessage( "ASKARON_REVIEWS_NEW_SESSION_EXPIRED" );
		}
	}
		
	// generate CAPTCHA
	$arResult["CAPTCHA_CODE"] = "";
	if ( $arResult["USE_CAPTCHA"] )
	{
		include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
		$cpt = new CCaptcha();
		$captchaPass = COption::GetOptionString("main", "captcha_password", "");
		if (strLen($captchaPass) <= 0)
		{
			$captchaPass = randString(10);
			COption::SetOptionString("main", "captcha_password", $captchaPass);
		}
		$cpt->SetCodeCrypt($captchaPass);
		$arResult["CAPTCHA_CODE"] = htmlspecialchars($cpt->GetCodeCrypt());
	}	
	
	if ( $_REQUEST["new_review_added"] == "Y" )
	{
		$arResult["NEW_ADDED"] = true;
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
