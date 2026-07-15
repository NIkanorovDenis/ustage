<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Наши контакты | USTAGE GROUP");
$APPLICATION->SetPageProperty("description", "Актуальная контактная информация");
$APPLICATION->SetTitle("Наши контакты");
?><div class="tb20-bottom">
</div>
<div itemscope="" itemtype="http://schema.org/LocalBusiness" class="tb20-bottom row bxr-page-contacts">
	<div class="col-md-6">
 <b>Адрес <span itemprop="name">USTAGE GROUP</span>:</b>
		<div class="bxr-border">
			<div>
				<div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
 <span itemprop="postalCode">194100</span>,&nbsp;<span itemprop="addressLocality">г.&nbsp;Санкт-Петербург</span>, <span itemprop="streetAddress">ул. Харченко</span>, д. 18
				</div>
 <time itemprop="openingHours" datetime="Mo, Tu, We, Th, Fr 10:00−19:00"><strong>Время работы:</strong> пн-пт с 10:00 до 19:00 <br>
 </time>
				<p>
 <b><br>
 </b>
				</p>
				<p>
 <b>Телефон:</b> <span itemprop="telephone"><a href="tel:+78124094991">+7(812) 409-49-91</a></span>
				</p>
				<p>
 <b>Эл. почта для заказов:</b>&nbsp;<span itemprop="email"><a href="mailto:sale@ustage-group.ru" target="_blank">sale@ustage-group.ru</a></span>
				</p>
			</div>
		</div>
	</div>
</div>
 <b>Эл. почта&nbsp;для общих вопросов:</b>&nbsp;<a href="mailto:office@ustage-group.ru" target="_blank">office@ustage-group.ru</a> <br>
 <br>
<div class="clearfix">
</div>
 <br>
 <br>
<div id="bxr-contact-map">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"named_area",
	Array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"COMPONENT_TEMPLATE" => "named_area",
		"EDIT_TEMPLATE" => "",
		"INCLUDE_PTITLE" => "",
		"PATH" => ""
	)
);?>
</div>
 <br>
<h4>Обратная связь</h4>
<div class="tb20-bottom">
	 Данный сервис предназначен для обратной связи. Воспользуйтесь формой, чтобы задать интересующий Вас вопрос, отправить комментарии, замечания или предложения.
</div>
 <br>
 <button class="bxr-color-button" href="jav * ascript:void(0);" data-toggle="modal" data-target="#bxr-feedback-popup"> <span class="fa fa-long-arrow-right"></span>
Задать вопрос </button> <br>
 <br>
 <br>
<h2 class="tb20-bottom">Реквизиты компании</h2>
<table class="table table-bordered">
<tbody>
<tr>
	<td>
		 Наименование:
	</td>
	<td>
		 ООО «Юстейдж»<br>
	</td>
</tr>
<tr>
	<td>
		 Юридический адрес:<br>
	</td>
	<td>
		 188660, Ленинградская обл, Всеволожский р-он, п Бугры, ул Нижняя, д.7<br>
	</td>
</tr>
<tr>
	<td>
		 Телефон:<br>
	</td>
	<td>
		 +7(812) 409-49-91
	</td>
</tr>
<tr>
	<td>
		 Эл. почта:<br>
	</td>
	<td>
 <a href="mailto:mail@linksoneone.com" target="_blank">office@ustage-group.ru</a><br>
	</td>
</tr>
<tr>
	<td>
		 ИНН:
	</td>
	<td>
		 4703156055
	</td>
</tr>
<tr>
	<td>
		 КПП:
	</td>
	<td>
		 470301001<br>
	</td>
</tr>
<tr>
	<td>
		 ОГРН:<br>
	</td>
	<td>
		 1184704007025<br>
	</td>
</tr>
<tr>
	<td>
		 ОКВЭД:<br>
	</td>
	<td>
		 46.90
	</td>
</tr>
<tr>
	<td>
		 ОКПО:<br>
	</td>
	<td>
		 28589773<br>
	</td>
</tr>
<tr>
	<td>
		 ОКТМО:<br>
	</td>
	<td>
		 41612402101<br>
	</td>
</tr>
<tr>
	<td>
		 ОКАТО:<br>
	</td>
	<td>
		 41212000008<br>
	</td>
</tr>
<tr>
	<td>
		 Наименование банка:<br>
	</td>
	<td>
		 ФИЛИАЛ "САНКТ-ПЕТЕРБУРГСКИЙ" АО "АЛЬФА-БАНК", САНКТ-ПЕТЕРБУРГ<br>
	</td>
</tr>
<tr>
	<td>
		 Расчетный счет:<br>
	</td>
	<td>
		 40702810932260002650<br>
	</td>
</tr>
<tr>
	<td>
		 Корреспондентский счет:&nbsp;<br>
	</td>
	<td>
		 30101810600000000786<br>
	</td>
</tr>
<tr>
	<td>
		 БИК:<br>
	</td>
	<td>
		 044030786<br>
	</td>
</tr>
</tbody>
</table><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>