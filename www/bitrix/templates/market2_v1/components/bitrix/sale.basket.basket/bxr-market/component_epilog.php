<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)  die();?>
<?if(isset($_REQUEST["print"]) && $_REQUEST["print"]=="y" && (!isset($arParams["PRINT_ORDER"]) || $arParams["PRINT_ORDER"] == "Y" )):?>
    <style>
        <?
            $filename = $_SERVER["DOCUMENT_ROOT"]."".SITE_TEMPLATE_PATH."/components/bitrix/sale.basket.basket/market/style.css";
            if (file_exists($filename)) {
                include ($filename);
            }
        ?>
        <?
            $filename = $_SERVER["DOCUMENT_ROOT"]."".SITE_TEMPLATE_PATH."/components/bitrix/sale.basket.basket/market/print.css";
            if (file_exists($filename)) {
                include ($filename);
            }
        ?>
    </style>
    <script>
        window.print();
    </script>
    <?die();?>
<?endif;?>