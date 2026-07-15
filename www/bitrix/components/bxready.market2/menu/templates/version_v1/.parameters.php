<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arColorMenu = array(
    "light" => GetMessage("LIGHT_STYLE_MENU"),
    "dark" => GetMessage("DARK_STYLE_MENU"),
    "color" => GetMessage("COLOR_STYLE_MENU"),
);

$arFontMenu = array(
    "normal" => GetMessage("FONT_NORMAL"),
    "ligth" => GetMessage("FONT_LIGHT"),
    "big" => GetMessage("FONT_BIG"),
);

$arIndentsMenu = array(
    "normal" => GetMessage("INDENTSFONT_NORMAL"),
    "little" => GetMessage("INDENTSFONT_LITTLE"),
    "big" => GetMessage("INDENTSFONT_LITTLE_BIG"),
);

$arTopMenu = array(
    "N" => GetMessage("ICO_TOP_MENU_N"),
    "ICO" => GetMessage("ICO_TOP_MENU_Y"),
    "ICO_DEFAULT" => GetMessage("ICO_TOP_MENU_DEFAULT"),
);

$arStyleMenuHover = array(
    "colored_light_new" => GetMessage("LIGHT_STYLE_MENU_NEW"),
    "colored_light" => GetMessage("LIGHT_STYLE_MENU"),
    "colored_color" => GetMessage("COLOR_STYLE_MENU"),
    "colored_dark" => GetMessage("DARK_STYLE_MENU"),    
);

$arPictureSection = array("N" => GetMessage("PICTURE_SECTION_N"), "ICO" => GetMessage("PICTURE_SECTION_ICO"), "ICO_DEFAULT" => GetMessage("PICTURE_SECTION_ICO_DEFAULT"));
$arViewSubsection = array("LINE" => GetMessage("VIEW_SUBSECTION_LINE"), "COLUMN" => GetMessage("VIEW_SUBSECTION_COLUMN"));
$arTemplateMenuHover = array("classic" => GetMessage("CLASSIC_HOVER_MENU"), "list" => GetMessage("LIST_HOVER_MENU"));

if($arCurrentValues["TEMPLATE_MENU_HOVER"] === "list") {
    $arPictureSection["IMG"] = GetMessage("PICTURE_SECTION_PICTURE");
    unset($arStyleMenuHover["colored_light_new"]);
    unset($arStyleMenuHover["colored_color"]);
    unset($arStyleMenuHover["colored_dark"]);
}
    

$arTemplateParameters = array(
    
    "COLOR_MENU" => array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("COLOR_MENU"),
        "TYPE" => "LIST",
        "VALUES" => $arColorMenu,
        "DEFAULT" => "light",
    ),
    
    "FONT_MENU" => array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("FONT_MENU"),
        "TYPE" => "LIST",
        "VALUES" => $arFontMenu,
        "DEFAULT" => "normal",
    ),
    
    "INDENT_ITEMS_MENU" => array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("INDENT_ITEMS_MENU"),
        "TYPE" => "LIST",
        "VALUES" => $arIndentsMenu,
        "DEFAULT" => "normal",
    ),
    
        
    "STRETCH_MENU" => array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("STRETCH_MENU"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    
    "HOVER_MODAL_BACKDROP" => array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("HOVER_MODAL_BACKDROP"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
    ),
    
    "IS_FIRST_CATALOG" => array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("IS_FIRST_CATALOG"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
    ),
    
    "ICO_TOP_MENU" => array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("ICO_TOP_MENU"),
        "TYPE" => "LIST",
        "VALUES" => $arTopMenu,
        "DEFAULT" => "N",
        "REFRESH" => "Y",
    ),
  
    "TEMPLATE_MENU_HOVER" => array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("TEMPLATE_MENU_HOVER"),
        "TYPE" => "LIST",
        "VALUES" => $arTemplateMenuHover,
        "DEFAULT" => "classic",
        "REFRESH" => "Y",
    ),    

    "STYLE_MENU_HOVER" => array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("STYLE_MENU"),
        "TYPE" => "LIST",
        "VALUES" => $arStyleMenuHover,
        "DEFAULT" => "colored_light",
    ),     

   
    /*"PICTURE_SECTION" => array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("PICTURE_SECTION"),
        "TYPE" => "LIST",
        "VALUES" => $arPictureSection,
        "DEFAULT" => "N",
        "REFRESH" => "Y",
    ),*/    
);

if($arCurrentValues["TEMPLATE_MENU_HOVER"] === "list") {
    $arTemplateParameters["PICTURE_SECTION_HOVER_LIST"] =  array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("PICTURE_SECTION"),
        "TYPE" => "LIST",
        "VALUES" => $arPictureSection,
        "DEFAULT" => "N",
        "REFRESH" => "Y",
    );
}
else {
    $arTemplateParameters["PICTURE_SECTION"] =  array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("PICTURE_SECTION"),
        "TYPE" => "LIST",
        "VALUES" => $arPictureSection,
        "DEFAULT" => "N",
        "REFRESH" => "Y",
    );
}

if($arCurrentValues["ICO_TOP_MENU"] === "ICO" || $arCurrentValues["ICO_TOP_MENU"] === "ICO_DEFAULT")
{  
    $arTopMenuColor = array(
        "light" => GetMessage("ICO_TOP_MENU_COLOR_LIGHT"),
        "dark" => GetMessage("ICO_TOP_MENU_COLOR_DARK"),
        "color" => GetMessage("ICO_TOP_MENU_COLOR_COLOR")
    );
    
    $arTemplateParameters["ICO_TOP_MENU_COLOR_1"] = array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("ICO_TOP_MENU_COLOR_1"),
        "TYPE" => "LIST",
        "VALUES" => $arTopMenuColor,
        "DEFAULT" => "color",
    );
    
    $arTemplateParameters["ICO_TOP_MENU_COLOR_2"] = array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("ICO_TOP_MENU_COLOR_2"),
        "TYPE" => "LIST",
        "VALUES" => $arTopMenuColor,
        "DEFAULT" => "light",
    );
}

if($arCurrentValues["PICTURE_SECTION"] === "ICO" || $arCurrentValues["PICTURE_SECTION"] === "ICO_DEFAULT")
{  
    $arTopMenuColor = array(
        "light" => GetMessage("ICO_TOP_MENU_COLOR_LIGHT"),
        "dark" => GetMessage("ICO_TOP_MENU_COLOR_DARK"),
        "color" => GetMessage("ICO_TOP_MENU_COLOR_COLOR")
    );
    
    $arTemplateParameters["ICO_HOVER_MENU_COLOR_1"] = array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("ICO_TOP_MENU_COLOR_1"),
        "TYPE" => "LIST",
        "VALUES" => $arTopMenuColor,
        "DEFAULT" => "color",
    );
    
    $arTemplateParameters["ICO_HOVER_MENU_COLOR_2"] = array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("ICO_TOP_MENU_COLOR_2"),
        "TYPE" => "LIST",
        "VALUES" => $arTopMenuColor,
        "DEFAULT" => "light",
    );
}




if($arCurrentValues["TEMPLATE_MENU_HOVER"] === "list")
{    
    
    $arPictureCategories = array("N" => GetMessage("PICTURE_CATEGARIES_N"), "left" => GetMessage("PICTURE_CATEGARIES_LEFT"), "right" => GetMessage("PICTURE_CATEGARIES_RIGHT"));
    $arTemplateParameters["PICTURE_CATEGARIES"] = array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("PICTURE_CATEGARIES"),
        "TYPE" => "LIST",
        "VALUES" => $arPictureCategories,
        "DEFAULT" => "N",
    );
    
    $arColHoverMenu = array("1" => "1", "2" => "2", "3" => "3", "4" => "4" );
    
    
    $arTemplateParameters["HOVER_MENU_COL_LG"] = array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("HOVER_MENU_COL_LG"),
        "TYPE" => "LIST",
        "VALUES" => $arColHoverMenu,
        "DEFAULT" => "2",
    );
    
    $arTemplateParameters["HOVER_MENU_COL_MD"] = array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("HOVER_MENU_COL_MD"),
        "TYPE" => "LIST",
        "VALUES" => $arColHoverMenu,
        "DEFAULT" => "2",
    );    
    
    $arTemplateParameters["HOVER_MENU_COL_SM"] = array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("HOVER_MENU_COL_SM"),
        "TYPE" => "LIST",
        "VALUES" => $arColHoverMenu,
        "DEFAULT" => "1",
    );
    
    $arTemplateParameters["HOVER_MENU_COL_XS"] = array(
        "PARENT" => "MENU_HOVER_BLOCKS",
        "NAME" => GetMessage("HOVER_MENU_COL_XS"),
        "TYPE" => "LIST",
        "VALUES" => $arColHoverMenu,
        "DEFAULT" => "1",
    );
    
}

?>