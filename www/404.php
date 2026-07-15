<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Ошибка 404. Страница не найдена.");
?>
        <div class="">Извините, но такой страницы не существует, либо произошла страшная, трагическая ошибка.<br>
            Вы можете <a href="/">Перейти на главную</a>, <a href="<?=SITE_DIR?>catalog/">Перейти в каталог</a> или
            <a href="javascript:history.go(-1)">Вернуться назад</a>, на страницу с которой вы пришли.</div>
	<div class="clear"></div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
