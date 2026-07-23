<?php
$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../');
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('CHK_EVENT', true);

ini_set('memory_limit', '256G');
ini_set('max_execution_time', '0');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

/**/
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/phpQuery-onefile.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/SimpleXLS.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/SimpleXLSX.php');

use Alchemy\Zippy\Zippy;
use Shuchkin\SimpleXLS;
use Shuchkin\SimpleXLSX;
/**/

\Bitrix\Main\Loader::requireModule("iblock");
\Bitrix\Main\Loader::requireModule("catalog");
\Bitrix\Main\Loader::requireModule("search");
\Bitrix\Main\Loader::requireModule("highloadblock");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$getParser = !empty($request->get('parser')) ? $request->get('parser') : 'info';
$getType = !empty($request->get('type')) ? $request->get('type') : 'update';

if (!empty($argv)) {

	if (!empty($argv[1])) {
		$getParser = htmlentities($argv[1]);
	}
	if (!empty($argv[2])) {
		$getType = htmlentities($argv[2]);
	}

}

$import = new parserUS($getParser, $getType);

class parserUS {

    const IBLOCK_ID = 32;
    const IBLOCK_TP_ID = 33;

	public $parser = '';
	public $type = '';

	private $parserHLID = '';
	private $domen = '';
	private $location = '';
	private $logs = '';
	private $logsError = '';
	private $sectionNew = '';

	private $brandsFromHL = [];

    private $productsFromCatalog = [];
    private $offersFromCatalog = [];
    private $productsFromUstage = []; /*if ustage set*/
    private $productsFromParser = [];
    private $productsUpdate = [];
    private $productsToDeactivate = [];

	private $apitoken = ''; /*if need*/
	private $parserCredentials = null;

    public function __construct($getParser, $getType) {

		$this->parser = $getParser;
		$this->type = $getType;	echo $getParser.': '.$getType;

		if ($this->getParserFromHL()) {

			$this->location = __DIR__ .'/logs';
			if (!is_dir($this->location)) {
				mkdir($this->location, 0755, True);
			}

			$this->logs = $this->location .'/'. $this->parser .'/'. $this->type .'_'. date('Ymd') .'.txt';
			$this->logsError = $this->location .'/'. $this->parser .'/error_'. date('Ymd') .'.txt';

			$this->tolog($this->logs, 'Start '. $this->type .' products '. $this->parser .';', false);

			if (method_exists($this, $this->parser)) {
				call_user_func([$this, $this->parser]);
			}

		 } else {

			 $this->info();

		 }

	}

	public function __destruct() {

		if ($this->parser && $this->logs) {

			$this->productsToDeactivate = array_diff($this->productsToDeactivate, $this->productsUpdate);
			$this->deactivatedProducts($this->productsToDeactivate);

			$this->tolog($this->logs, 'End '. $this->type .' products '. $this->parser .';', true);

		}

	}

	public function __debugInfo()  {

		return [
			'parser' => $this->parser,
			'type'   => $this->type,
		];
	}

	public function __call($name, $arguments) {

		echo 'not set: '. $name;

	}

	public function info() {

		echo $this->parser;

	}

	/*Edsy*/
	private function edsy() {

		$this->productsFromCatalog = $this->getProductsFromCatalog();
		$this->productsFromParser  = $this->edsyGetProductsFromSource();

	}

	private function edsyGetProductsFromSource() {

		$items = [];

		//$filenameEdsy = 'https://edsy.ru/upload/export.xml';
		$filenameEdsy = 'https://ustage-group.ru/import/edsy_ostatki.xml';
		$edsyData = $this->getDataCurl($filenameEdsy);

		if ($edsyData) {

			$filename = $this->parser .'_ostatki.xml';
			$this->toFile(__DIR__ .'/'. $filename, $edsyData);

			if ($xmlObj = $this->getsrcfileToObject($filenameEdsy)) {

				$el = new CIBlockElement;

				foreach ($xmlObj->catalog->products->product as $item) {

					$properties = [];
					$noused_props = ['CML2_ARTICLE', 'CML2_TRAITS', 'CML2_BASE_UNIT', 'CML2_TAXES'];
					$article = '';


					if (!empty($item->properties->property)){
						foreach ($item->properties->property as $property) {

							$property = json_decode(json_encode((array)$property), TRUE);

							if (empty($noused_props) || !in_array($property['code'], $noused_props)) {
								$properties[$property['code']] = $property['name'] .': '. $property['value'];
							}

							if ($property['code'] == 'CML2_ARTICLE') {

								$article = $property['value'];

							}

						}
					}

					if (!empty($article)) {

						$productID = false;

						if (empty($this->productsFromCatalog) || !isset($this->productsFromCatalog[$article])) {
							if ($this->type == 'add') {

								$properties_text = !empty($properties) ? '<h3>Характеристики</h3><p>'. implode('<br>', $properties). '</p>' : '';

								$arLoadProductArray = [
									"NAME"              => (string)$item->name,
									"ACTIVE"            => 'N',
									"IBLOCK_SECTION" 	=> $this->sectionNew,
									"IBLOCK_ID"         => self::IBLOCK_ID,
									"CODE"              => (string)$item->code,
									"PREVIEW_TEXT"      => (string)$item->preview_text,
									"PREVIEW_TEXT_TYPE" => 'HTML',
									"DETAIL_TEXT"       => (string)$item->detail_text. $properties_text,
									"DETAIL_TEXT_TYPE"  => 'HTML',
									"XML_ID" => (string)$item->xml_id
								];

								$productID = $el->Add($arLoadProductArray);

								if ($productID) {

									CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [
										'UPLOADED_FROM_PAGE' => $this->domen . $item->url,
										'CML2_ARTICLE' => $article,
									]);
									$this->tolog($this->logs, 'Add product - '. $productID .';', true);

								} else {

									$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

								}

							}

						} else {

							$productID = $this->productsFromCatalog[$article]['ID'];

						}

						if (!empty($productID)) {

							$this->updatePriceStore($productID, $article, $item->quantity, $item->price);

						}

					}

				}

			}

		}

		return $items;

	}

	/*Showatelier*/
	private function showatelier() {

		$this->productsFromCatalog = $this->getProductsFromCatalog();

		if ($this->type == 'add') {

			$this->showatelierGetItemsFromSource();

		} else {

			$this->showatelierUpdateFromPrice();

		}

	}

	private function showatelierUpdateFromPrice() {

		$this->productsFromParser = $this->showatelierGetItemsFromPrice();

		$el = new CIBlockElement;

		foreach ($this->productsFromParser as $article=>$product) {

			$productID = $this->productsFromCatalog[$article]['ID'];

			if (!empty($productID)) {

				$this->updatePriceStore($productID, $article, $product['STORE'], $product['PRICE']);

			}

		}

	}

	private function showatelierGetItemsFromPrice() {

		$items = [];

		$filenameShowatelier = 'https://showatelier.ru/filedownload/SAPrice.xls';
		//$filenameShowatelier = 'https://ustage-group.ru/import/showatelier_ostatki.xls';
		$showatelierXlsData = $this->getDataCurl($filenameShowatelier);

		if ($showatelierXlsData) {

			$filename = $this->parser .'_ostatki.xls';
			$this->toFile(__DIR__ .'/'. $filename, $showatelierXlsData);

			if ($xls = SimpleXLS::parse(__DIR__ .'/'. $filename)) {
				foreach ($xls->rows() as $xlsRow) {

					if (empty($xlsRow[1]) || empty($xlsRow[4])) {
						continue;
					}

					$items[$xlsRow[1]] = [
						'PRICE' => (int)$xlsRow[4],
						'STORE' => 100,
					];

				}

			} else {
				$this->tolog($this->logsError, 'empty SimpleXLS::parse;', true);
			}

		} else {
			$this->tolog($this->logsError, 'empty showatelierXlsData;', true);
		}

		return $items;

	}

	private function showatelierGetItemsFromSource() {

		$filenameShowatelier = 'https://showatelier.ru/sitemap.xml';
		//$filenameShowatelier = 'https://ustage-group.ru/import/showatelier_sitemap.xml';
		$showatelierXmlData = $this->getDataCurl($filenameShowatelier);

		if ($showatelierXmlData) {

			$filename = $this->parser .'_sitemap.xml';
			$this->toFile(__DIR__ .'/'. $filename, $showatelierXmlData);

			if ($xmlObj = $this->getsrcfileToObject($filenameShowatelier)) {

				$el = new CIBlockElement;

				foreach ($xmlObj->url as $item) {
					if (!empty($item->loc) && mb_strpos($item->loc, '/katalog/') !== false && mb_strpos($item->loc, '.html') !== false) {

						$product = $this->showatelierPrepareProductFromUrl($item->loc);

						if (!empty($product['NAME']) && !empty($product['ARTICLE'])) {

							$productID = false;

							if (empty($this->productsFromCatalog) || !isset($this->productsFromCatalog[$product['ARTICLE']])) {
								if ($this->type == 'add') {

									$arLoadProductArray = [
										"NAME"              => $product['NAME'],
										"ACTIVE"            => 'N',
										"IBLOCK_SECTION" 	=> $this->sectionNew,
										"IBLOCK_ID"         => self::IBLOCK_ID,
										"CODE"              => \Cutil::translit($product['NAME'], 'ru', ['replace_other'=>'']),
										"PREVIEW_TEXT"       => $product['PREVIEW_TEXT'],
										"PREVIEW_TEXT_TYPE"  => 'HTML',
										"DETAIL_TEXT"       => $product['DETAIL_TEXT'],
										"DETAIL_TEXT_TYPE"  => 'HTML',
									];
									if (!empty($product['DETAIL_PICTURE'])) {
										$arLoadProductArray['DETAIL_PICTURE'] = $product['DETAIL_PICTURE'];
										$arLoadProductArray['PREVIEW_PICTURE'] = $product['DETAIL_PICTURE'];
									}

									$productID = $el->Add($arLoadProductArray);

									if ($productID) {

										CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [
											'UPLOADED_FROM_PAGE' => $item->loc,
											'CML2_ARTICLE' => $product['ARTICLE'],
											'MORE_PHOTO' => $product['PHOTOS'],
											'UPLOADED_PHOTO' => $product['DETAIL_PICTURE_URL'],
											'MANUFACTURER' => $product['BREND'],
										]);
										$this->tolog($this->logs, 'Add product - '. $productID .';', true);

									} else {

										$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

									}

								}

							} else {

								$productID = $this->productsFromCatalog[$product['ARTICLE']]['ID'];

							}

							if (!empty($productID)) {

								$this->updatePriceStore($productID, $product['ARTICLE'], false, $product['PRICE'], true);

							}

						}

					}

				}

			}

		}

	}

	private function showatelierPrepareProductFromUrl($url) {

		$product = [];

		if (!empty($url)) {

			$html = $this->getDataCurl($url);
			if (!empty($html)) {

				$doc = phpQuery::newDocument($html);

				$product['ID'] = '';

				$product['NAME'] = trim(pq($doc->find('div.product_name'))->text());

				$product['PREVIEW_TEXT'] = trim(pq($doc->find('div.product_desc'))->text());

				$product['DETAIL_TEXT'] = strip_tags(pq($doc->find('.product_descriptions .view_block'))->html(), '<p>,<b>,<br>,<tr>,<td>,<table>,<ul>,<li>,<iframe>,<h3>,<h4>,<h2>');

				$product['ARTICLE'] = trim(str_replace('Артикул:', '', pq($doc->find('.product_artikul'))->text()));

				$product['DETAIL_PICTURE_URL'] = '';
				$product['PHOTOS'] = [];
				$dopImages = $doc->find('.product_images a');
				if ($dopImages) {
					foreach ($dopImages as $dopImage) {

						$urlImage = $this->domen . pq($dopImage)->attr('href');

						if (empty($product['DETAIL_PICTURE_URL'])) {
							$product['DETAIL_PICTURE_URL'] = $urlImage;
						}

						$product['PHOTOS'][] = CFile::MakeFileArray($urlImage);

					}
				}
				if (!empty($product['PHOTOS'])) {
					$product['DETAIL_PICTURE'] = $product['PHOTOS'][0];
				}

				$product['BREND'] = trim(str_replace('Бренд:', '', pq($doc->find('.product_brand'))->text()));

				$product['PRICE'] = trim(str_replace(['руб.', ' '], '', pq($doc->find('.current_price'))->text()));

			} /*else {

				$this->tolog($this->logsError, 'page error - '. $url.';', true);

			}*/

		}

		return $product;

	}

	/*GlobalEffects*/
	private function globaleffects() {

		$this->productsFromCatalog = $this->getProductsFromCatalog(true);
		$this->globaleffectsGetItemsFromSource();

	}

	private function globaleffectsGetItemsFromSource() {

		$filenameGlobal = 'https://globaleffects.ru/sitemap.xml';
		//$filenameGlobal = 'https://ustage-group.ru/import/globaleffects_sitemap.xml';
		$globalXmlData = $this->getDataCurl($filenameGlobal);

		if ($globalXmlData) {

			$filename = $this->parser .'_sitemap.xml';
			$this->toFile(__DIR__ .'/'. $filename, $globalXmlData);

			if ($xmlObj = $this->getsrcfileToObject($filenameGlobal)) {

				$el = new CIBlockElement;

				foreach ($xmlObj->url as $item) {
					if (!empty($item->loc) && mb_strpos($item->loc, '/product/') !== false) {

						$productUrl = (string)$item->loc;
						$product = $this->globaleffectsPrepareProductFromUrl($item->loc);

						if (!empty($product['NAME'])) {

							$productID = false;

							if (empty($this->productsFromCatalog) || !isset($this->productsFromCatalog[$productUrl])) {
								if ($this->type == 'add') {

									$arLoadProductArray = [
										"NAME"              => $product['NAME'],
										"ACTIVE"            => 'N',
										"IBLOCK_SECTION" 	=> $this->sectionNew,
										"IBLOCK_ID"         => self::IBLOCK_ID,
										"CODE"              => \Cutil::translit($product['NAME'], 'ru', ['replace_other'=>'']),
										"PREVIEW_TEXT"       => $product['PREVIEW_TEXT'],
										"PREVIEW_TEXT_TYPE"  => 'HTML',
										"DETAIL_TEXT"       => $product['DETAIL_TEXT'],
										"DETAIL_TEXT_TYPE"  => 'HTML',
									];
									if (!empty($product['DETAIL_PICTURE'])) {
										$arLoadProductArray['DETAIL_PICTURE'] = $product['DETAIL_PICTURE'];
										$arLoadProductArray['PREVIEW_PICTURE'] = $product['DETAIL_PICTURE'];
									}

									$productID = $el->Add($arLoadProductArray);

									if ($productID) {

										CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [
											'UPLOADED_FROM_PAGE' => $item->loc,
											'MORE_PHOTO' => $product['PHOTOS'],
											'UPLOADED_PHOTO' => $product['DETAIL_PICTURE_URL'],
											'MORE_PHOTO' => $product['PHOTOS'],
										]);
										$this->tolog($this->logs, 'Add product - '. $productID .';', true);

									} else {

										$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

									}

								}

							} else {

								$productID = $this->productsFromCatalog[$productUrl]['ID'];

							}

							if (!empty($productID)) {

								$this->updatePriceStore($productID, $productUrl, false, $product['PRICE'], true);

							}

						}

					}

				}

			}

		}

	}

	private function globaleffectsPrepareProductFromUrl($url) {

		$product = [];

		if (!empty($url)) {

			$html = $this->getDataCurl($url);
			if (!empty($html)) {

				$doc = phpQuery::newDocument($html);

				$product['ID'] = '';

				$product['NAME'] = trim(pq($doc->find('h1'))->text());

				$product['PREVIEW_TEXT'] = pq($doc->find('.product-desc div[itemprop="description"] p:eq(0)'))->text();

				$product['DETAIL_TEXT'] = pq($doc->find('.product-desc div[itemprop="description"]'))->html();

				$urlImage = pq($doc->find('.img-block img'))->attr('src');
				if (!empty($urlImage)) {

					$product['DETAIL_PICTURE_URL'] = $urlImage;

					$product['DETAIL_PICTURE'] = CFile::MakeFileArray($urlImage);

				}

				$product['PHOTOS'] = [];
				$dopImages = $doc->find('.product-gal a.gal-item');
				if ($dopImages) {
					foreach ($dopImages as $dopImage) {

						$dopImageUrl = pq($dopImage)->attr('href');

						$product['PHOTOS'][] = CFile::MakeFileArray($dopImageUrl);

					}
				}

				$product['PRICE'] = trim(pq($doc->find('.price span[itemprop="price"]'))->text());

			}
		}

		return $product;

	}



	/*ltm*/
	private function ltm() {

		$this->productsFromParser = $this->ltmGetPricelistFromLtm();
		if (empty($this->productsFromParser)) {
			$this->tolog($this->logsError, 'LTM import aborted: source contains no products;', true);
			return;
		}

		$this->productsFromCatalog = $this->getProductsFromCatalog();

		$el = new CIBlockElement;

		foreach ($this->productsFromParser as $article => $item) {

			$productID = false;

			if (empty($this->productsFromCatalog) || !isset($this->productsFromCatalog[$article])) {
				if ($this->type == 'add') {

					$arLoadProductArray = [
						"NAME"              => $item['NAME'],
						"ACTIVE"            => 'N',
						"IBLOCK_SECTION" 	=> $this->sectionNew,
						"IBLOCK_ID"         => self::IBLOCK_ID,
						"CODE"              => \Cutil::translit($item['NAME'], 'ru', ['replace_other'=>'']),
					];

					$product = $this->ltmPrepareProductFromUrl($item['URL']);

					if (!empty($product['NAME'])) {

						$arLoadProductArray["PREVIEW_TEXT"] = $product['PREVIEW_TEXT'];
						$arLoadProductArray["PREVIEW_TEXT_TYPE"] = 'HTML';
						$arLoadProductArray["DETAIL_TEXT"] = $product['DETAIL_TEXT'];
						$arLoadProductArray["DETAIL_TEXT_TYPE"] = 'HTML';

						if (!empty($product['DETAIL_PICTURE'])) {
							$arLoadProductArray['DETAIL_PICTURE'] = $product['DETAIL_PICTURE'];
							$arLoadProductArray['PREVIEW_PICTURE'] = $product['DETAIL_PICTURE'];
						}

					}

					$productID = $el->Add($arLoadProductArray);

					if ($productID) {

						CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [
							'UPLOADED_FROM_PAGE' => $item['URL'],
							'CML2_ARTICLE' => $item['CODE'],
							'MORE_PHOTO' => $product['PHOTOS'],
							'UPLOADED_PHOTO' => $product['DETAIL_PICTURE_URL'],
						]);
						$this->tolog($this->logs, 'Add product - '. $productID .';', true);

					} else {

						$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

					}

				}

			} else {

				$productID = $this->productsFromCatalog[$article]['ID'];

			}

			if (!empty($productID)) {

				$this->updatePriceStore($productID, $article, $item['STORE'], $item['PRICE']);

			}

		}

	}

	private function ltmPrepareProductFromUrl($url) {

		$product = [];

		if (!empty($url)) {

			$html = $this->getDataCurl($url);
			if (!empty($html)) {

				$doc = phpQuery::newDocument($html);

				$product['ID'] = '';

				$product['NAME'] = trim(pq($doc->find('h1'))->text());

				$product['PREVIEW_TEXT'] = trim(pq($doc->find('.product__text .text-in'))->text());

				$product['DETAIL_TEXT'] = pq($doc->find('.product__properties'))->html();

				$product['ARTICLE'] = str_replace('Код товара: ', '', pq($doc->find('.product__code'))->text());

				$product['DETAIL_PICTURE_URL'] = '';
				$product['PHOTOS'] = [];
				$dopImages = $doc->find('.gallery-item a');
				if ($dopImages) {
					foreach ($dopImages as $dopImage) {

						$urlImage = $this->domen . pq($dopImage)->attr('href');

						if (empty($product['DETAIL_PICTURE_URL'])) {
							$product['DETAIL_PICTURE_URL'] = $urlImage;
						}

						$product['PHOTOS'][] = CFile::MakeFileArray($urlImage);

					}
				}
				if (!empty($product['PHOTOS'])) {
					$product['DETAIL_PICTURE'] = $product['PHOTOS'][0];
				}

			} else {

				$this->tolog($this->logsError, 'page error - '. $url.';', true);

			}

		}

		return $product;

	}

	private function ltmGetPricelistFromLtm() {

		$items = [];

		$filenameLtm = 'https://ltm-music.ru/upload/excel/ostatki_retail.xls?1676962838';
		//$filenameLtm = 'https://ustage-group.ru/import/ltm-music_ostatki.xls';
		$ltmXlsData = $this->getDataCurl($filenameLtm);

		if ($ltmXlsData) {

			$filename = $this->parser .'_ostatki.xls';
			$this->toFile(__DIR__ .'/'. $filename, $ltmXlsData);

			if ($xls = SimpleXLS::parse(__DIR__ .'/'. $filename)) {
				foreach ($xls->rows() as $xlsRow) {

					if (
						empty($xlsRow[0])
						|| empty($xlsRow[7])
						|| trim((string)$xlsRow[0]) === 'Номенклатура'
						|| trim((string)$xlsRow[7]) === 'Код'
					) {
						continue;
					}

					$exp = [
						'Гитара классическая', 'Гитара акустическая', 'Гитара электроакустическая', 'Гитара электро', 'Гитара бас', 'Гитарные усилители, кабинеты и комбо', 'Чехлы для комбоусилителей', 'Педаль эффектов гитарная', 'Педаль эффектов для электрогитары', 'Аксессуары для гитар', 'Гитарные стойки, подставки и держатели', 'Датчики, звукосниматели для гитар', 'Комплектующие для гитар', 'Медиаторы, слайды', 'Ремни гитарные', 'Чехлы и кейсы гитарные',
						'Блок-флейта', 'Средства для ухода за духовыми', 'Трости для духовых', 'Рояль акустический', 'Рояль цифровой', 'Фортепиано акустическое', 'Фортепиано цифровое', 'Синтезатор', 'Синтезатор профессиональный', 'Педаль для клавишных', 'Стойки, стулья, подставки для клавишных', 'Чехлы и кейсы для клавишных',
						'Смычок', 'Прочие смычковые аксессуары', 'Скрипка', 'Струны для гитары классик', 'Струны для гитары акустик', 'Струны для гитары электрик', 'Струны для гитары бас', 'Струны для смычковых (скрипка, виолончель)', 'Струны для народных (домра, балалайка и проч.)', 'Струны для укулеле',
						'Монитор для электронных барабанов', 'Перкуссия', 'Тарелка', 'Ударная установка электронная', 'Палочки для ударных', 'Пластик', 'Чехлы, кейсы, сумки для ударных', 'Аксессуары для ударных',
						'Стойки для укулеле', 'Укулеле', 'Чехлы для укулеле',
						'Подсветка для пюпитра', 'Подставки и пюпитры', 'Стул, банкетка', 'Тюнеры, метрономы',
						'Стыковые изделия'
					];
					if (in_array($xlsRow[6], $exp)) {
						continue;
					}

					$quantity = 0;
					if ($xlsRow[11]) {
						$quantity += (int)$this->clearStr($xlsRow[11]); //Москва остаток
					}
					if ($xlsRow[12]) {
						$quantity -= (int)$this->clearStr($xlsRow[12]); //Москва резерв
					}
					if ($xlsRow[13]) {
						$quantity += (int)$this->clearStr($xlsRow[13]); // Новосибирск остаток
					}
					if ($xlsRow[14]) {
						$quantity -= (int)$this->clearStr($xlsRow[14]); // Новосибирск резерв
					}
					if ($xlsRow[15]) {
						$quantity += (int)$this->clearStr($xlsRow[15]); // Псков остаток
					}
					if ($xlsRow[16]) {
						$quantity -= (int)$this->clearStr($xlsRow[16]); // Псков резерв
					}

					// Резерв в прайс-листе иногда больше физического остатка.
					// В Bitrix отрицательного складского остатка быть не должно.
					$quantity = max(0, $quantity);

					$items[$xlsRow[7]] = [
						'NAME' => $xlsRow[0],
						'CODE' => $xlsRow[7],
						'URL' => $this->domen. 'product/'. $xlsRow[7] .'/',
						'PRICE' => (int)$xlsRow[10],
						'STORE' => $quantity,
					];

				}

			} else {
				$this->tolog($this->logsError, 'empty SimpleXLS::parse;', true);
			}

		} else {
			$this->tolog($this->logsError, 'empty ltmXlsData;', true);
		}

		return $items;

	}

	/*riggershop*/
	private function riggershop() {

		$this->productsFromCatalog = $this->getProductsFromCatalog();

		if (!empty($this->productsFromCatalog)) {

			$parent_id = array_column($this->productsFromCatalog, 'ID');
			if (!empty($parent_id)) {

				$this->offersFromCatalog = $this->getOffersFromCatalog($parent_id);

			}

			$this->productsFromParser  = $this->riggershopGetProductsFromSource();
			if (!empty($this->productsFromParser)) {

				$this->riggershopUpdate();

			}

		}

	}

	private function riggershopUpdate() {

		$items = $this->productsFromParser;

		$el = new CIBlockElement;

		if (!empty($items['PRODUCTS'])) {
			foreach($items['PRODUCTS'] as $article=>$product) {

				if ($this->type == 'add') {

					if (!empty($product['VALUES'])) {

						$productID = $el->Add($product['VALUES']);
						if ($productID) {

							if (!empty($product['PARAMS'])) {
								CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, $product['PARAMS']);
							}

							$this->tolog($this->logs, 'Add product - '. $productID .';', true);

						} else {

							$this->tolog($this->logsError, 'Add product ERROR - '. $product['VALUES']['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

						}

					}

				} else {

					if (isset($this->productsFromCatalog[$article]) && !empty($this->productsFromCatalog[$article]['ID'])) {

						$this->updatePriceStore($this->productsFromCatalog[$article]['ID'], $article, '100', $product['PRICE']);

					}

				}

			}

		}

		if (!empty($items['OFFERS'])) {
			foreach($items['OFFERS'] as $article=>$offer) {

				if ($this->type == 'add') {

					if (!empty($offer['VALUES'])) {

						$offerID = $el->Add($offer['VALUES']);
						if ($offerID) {

							if (!empty($offer['PARAMS'])) {
								CIBlockElement::SetPropertyValuesEx($offerID, self::IBLOCK_TP_ID, $offer['PARAMS']);
							}

							$this->tolog($this->logs, 'Add offer - '. $offerID .';', true);


						} else {

							$this->tolog($this->logsError, 'Add offer ERROR - '. $offer['VALUES']['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

						}

					}

				} else {

					if (!empty($this->offersFromCatalog) && isset($this->offersFromCatalog[$article]) && !empty($this->offersFromCatalog[$article]['ID'])) {

						$this->updatePriceStore($this->offersFromCatalog[$article]['ID'], $article, '100', $offer['PRICE'], false, true);

					}

				}

			}

		}



	}

	private function riggershopGetProductsFromSource() {

		$items = [
			'PRODUCTS' => [],
			'OFFERS' => [],
		];

		$filenameRigger = 'https://crm.riggershop.ru/bitrix/catalog_export/export_tgshop.xml';
		//$filenameRigger = 'https://ustage-group.ru/import/riggershop_ostatki.xml';
		$riggerData = $this->getDataCurl($filenameRigger);

		if ($riggerData) {

			$filename = $this->parser .'_ostatki.xml';
			$this->toFile(__DIR__ .'/'. $filename, $riggerData);

			if ($xmlObj = $this->getsrcfileToObject($filenameRigger)) {

				$colors = $this->getDatasFromHL(1);
				$brands = $this->getDatasFromHL(2);
				$sizes = $this->getDatasFromList('SIZE');

				foreach ($xmlObj->shop->offers->offer as $offer) {

					$productID = false;

					$params = [];
					foreach($offer->param as $param) {

						$attr = (string)$param->attributes()->name;

						if (!empty($params) && isset($params[$attr])) {
							$attr .= '_ТП';
						}
						$params[$attr] = (string)$param;

					}

					if (!empty($params['Артикул'])) {

						if (isset($params['Артикул_ТП'])) {
							$TP = true;
							$article = $params['Артикул_ТП'];
						} else {
							$TP = false;
							$article = $params['Артикул'];
						}

						if ($TP) {
							if (!empty($this->offersFromCatalog) && isset($this->offersFromCatalog[$article])) {

								$productID = $this->offersFromCatalog[$article]['ID'];

							}
						} else {
							if (!empty($this->productsFromCatalog) && isset($this->productsFromCatalog[$article])) {

								$productID = $this->productsFromCatalog[$article]['ID'];

							}
						}

						if (!$productID) {
							if ($this->type == 'add') {

								$productArray['VALUES'] = [
										"NAME"              => (string)$offer->name,
										"ACTIVE"            => 'N',
										//"CODE"              => \Cutil::translit((string)$offer->name, 'ru', ['replace_other'=>'']),
										"PREVIEW_TEXT"      => (string)$offer->description,
										"PREVIEW_TEXT_TYPE" => 'HTML',
										"DETAIL_TEXT"       => (string)$offer->description,
										"DETAIL_TEXT_TYPE"  => 'HTML',
								];
								$productArray['PARAMS'] = [
									'UPLOADED_FROM_PAGE' => (string)$offer->url,
									'CML2_ARTICLE' => $article,
								];

								$photos = [];
								foreach($offer->picture as $photo) {

									$photos[] = (string)$photo;

								}
								if (!empty($photos)) {

									$productArray['VALUES']['DETAIL_PICTURE'] = CFile::MakeFileArray(trim($photos[0]));
									$productArray['VALUES']['PREVIEW_PICTURE'] = $productArray['VALUES']['DETAIL_PICTURE'];

									$productArray['PARAMS']['UPLOADED_PHOTO'] = trim($photos[0]);
									//$productArray['PARAMS']['MORE_PHOTO'] = $photos;

								}

								if (isset($params['Производитель'])) {

									$brand = $params['Производитель'];
									if (!empty($brands) && isset($brands[$brand])) {

										$productArray['VALUES']['PARAMS']['MANUFACTURER'] = $brands[$brand];

									}

								}

								if ($TP) {

									$articleParent = $params['Артикул'];
									if (!isset($this->productsFromCatalog[$articleParent])) {

										$productArray['VALUES']['IBLOCK_ID'] = self::IBLOCK_ID;
										$productArray['VALUES']['IBLOCK_SECTION'] = $this->sectionNew;
										$productArray['VALUES']['CODE'] = \Cutil::translit($productArray['VALUES']['NAME'], 'ru', ['replace_other'=>'']);

										$items['PRODUCTS'][$articleParent] = $productArray;

									} else {

										$productArray['PARAMS']['CML2_LINK'] = $this->productsFromCatalog[$articleParent]['ID'];

									}

									$productArray['VALUES']['IBLOCK_ID'] = self::IBLOCK_TP_ID;
									$productArray['VALUES']['IBLOCK_SECTION'] = '';

									if (isset($params['Цвет'])) {

										$color = $params['Цвет'];
										if (!empty($colors) && isset($colors[$color])) {

											$productArray['PARAMS']['COLOR'] = $colors[$color]['XML_ID'];
											$productArray['VALUES']['NAME'] .= ', '. $color;

										}

									}
									if (isset($params['Размер'])) {

										$size = $params['Размер'];
										if (!empty($sizes) && isset($sizes[$size])) {

											$productArray['PARAMS']['SIZE'] = $sizes[$size];
											$productArray['VALUES']['NAME'] .= ', '. $size;

										}

									}

									$productArray['VALUES']['CODE'] = \Cutil::translit($productArray['VALUES']['NAME'], 'ru', ['replace_other'=>'']);

									$items['OFFERS'][$article] = $productArray;

								} else {

									$productArray['VALUES']['IBLOCK_ID'] = self::IBLOCK_ID;
									$productArray['VALUES']['IBLOCK_SECTION'] = $this->sectionNew;
									$productArray['VALUES']['CODE'] = \Cutil::translit($productArray['VALUES']['NAME'], 'ru', ['replace_other'=>'']);

									$items['PRODUCTS'][$article] = $productArray;

								}

							}
						} else {
							if ($this->type !== 'add') {

								if ($TP) {

									$items['OFFERS'][$article]['PRICE'] = (string)$offer->price;

								} else {

									$items['PRODUCTS'][$article]['PRICE'] = (string)$offer->price;

							}

							}
						}

					}

				}

			}

		}

		return $items;

	}


	/*anzhee*/
	private function anzhee() {

		$this->productsFromCatalog = $this->getProductsFromCatalog();
		$this->productsFromParser  = $this->anzheeGetProductsFromSource();

		if (!empty($this->productsFromCatalog)) {

			$this->brandsFromHL = $this->getDatasFromHL(2);

			$parent_id = array_column($this->productsFromCatalog, 'ID');
			if (!empty($parent_id)) {

				$this->offersFromCatalog = $this->getOffersFromCatalog($parent_id);

			}

			$this->anzheeUpdate();

		}

	}

	private function anzheeUpdate() {

		if (!empty($this->productsFromCatalog) && !empty($this->productsFromParser)) {

			$el = new CIBlockElement;

			foreach ($this->productsFromParser as $article=>$product) {

				$productID = false;

				$offer = $product['TYPE'] == 'TP' ? true : false;

				if (!isset($this->productsFromCatalog[$product['GUID']]) && (empty($this->offersFromCatalog) || !isset($this->offersFromCatalog[$product['GUID']]))) {
					if ($this->type == 'add') {

						$arLoadProductArray = [
							"NAME"           => $product['NAME'],
							"ACTIVE"         => 'N',
							"CODE"           => \Cutil::translit($product['NAME'], 'ru', ['replace_other'=>'']),
						];
						/*if (!empty($product['PHOTO']) && $this->getDataCurl($product['PHOTO'])) {
							$arLoadProductArray['DETAIL_PICTURE'] = CFile::MakeFileArray(trim($product['PHOTO']));
							$arLoadProductArray['PREVIEW_PICTURE'] = $arLoadProductArray['DETAIL_PICTURE'];
						}*/
						if (!empty($product['ANONS'])) {
							$arLoadProductArray['PREVIEW_TEXT'] = $product['ANONS'];
							$arLoadProductArray['PREVIEW_TEXT_TYPE'] = 'HTML';
						}
						if (!empty($product['TEXT'])) {
							$arLoadProductArray['DETAIL_TEXT'] = $product['TEXT'];
							$arLoadProductArray['DETAIL_TEXT_TYPE'] = 'HTML';
						}

						if ($product['TYPE'] == 'TP') {

							$arLoadProductArray['IBLOCK_ID'] = self::IBLOCK_TP_ID;

						} else {

							$arLoadProductArray['IBLOCK_ID'] = self::IBLOCK_ID;
							$arLoadProductArray['IBLOCK_SECTION'] = $this->sectionNew;

						}

						$productID = $el->Add($arLoadProductArray);

						if ($productID) {

							if ($offer) {

								CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_TP_ID, [
									'CML2_ARTICLE' => $product['SKU'],
									'CML2_LINK'    => $this->productsFromCatalog[$product['CML2']]['ID'],
									'SIZE' 		   => $product['WEIGHT'] .'x'. $product['HEIGHT'] .'x'. $product['WIDTH'] .'x'. $product['VOLUME'],
									'GUID' 		   => $product['GUID'],
									'UPLOADED_PHOTO' => $product['PHOTO'],
								]);

							} else {

								CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [
									'UPLOADED_FROM_PAGE' => $this->domen .'check-url-from-site/',
									'CML2_ARTICLE' 		 => $product['SKU'],
									'RAZMER' 			 => $product['WEIGHT'] .'x'. $product['HEIGHT'] .'x'. $product['WIDTH'] .'x'. $product['VOLUME'],
									'GUID' 		  		 => $product['GUID'],
									'UPLOADED_PHOTO'	 => $product['PHOTO'],
									//'BRAND' 			 => isset($this->brandsFromHL[$product['BRAND']]) ? $this->brandsFromHL[$product['BRAND']]['XML_ID'] : '',
									//'COUNTRY' 		 => $product['COUNTRY'],
								]);

							}

							$this->tolog($this->logs, 'Add product - '. $productID .';', true);

						} else {

							$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

						}

					}
				} else {

					$productID = isset($this->offersFromCatalog[$product['GUID']]) ? $this->offersFromCatalog[$product['GUID']]['ID'] : $this->productsFromCatalog[$product['GUID']]['ID'];

				}

				if (!empty($productID)) {

					$this->updatePriceStore($productID, $article, $product['STORE'], $product['PRICE'], false, $offer);

				}

			}
		}

	}

	private function anzheeGetProductsFromSource() {

		$items = [];

		$filenameAnzhee = 'https://backoffice24.ru:1010/anzhee-stock.csv';
		$anzheePriceData = $this->getDataCurl($filenameAnzhee);

		if ($anzheePriceData) {

			$filename = __DIR__ .'/'. 'anzhee_pricelist.csv';
			$anzheePriceData = iconv('Windows-1251', 'UTF-8', $anzheePriceData);
			$this->toFile($filename, $anzheePriceData);

			if (($f = fopen($filename, 'r')) !== FALSE) {
				while (($arRow = fgetcsv($f, 10000, ';')) !== false) {

					$GUID = $arRow[0];
					$GUID_TP = $arRow[1];
					$NAME = trim($arRow[3]);
					$tp = !empty($GUID_TP) ? true : false;

					if (!empty($NAME)) {

						$item = [
							'BRAND' => $arRow[5],
							'PHOTO' => str_replace('anzhee-light.ru', 'anzhee.ru', $arRow[7]),
							'ANONS' => $arRow[9],
							'TEXT' => $arRow[10],
							'ACTIVE' => mb_strtolower($arRow[11]) =='да' ? 'Y' : 'N',
							'COUNTRY' => $arRow[22],
						];
						$item_dop = [
							'TIP' => $arRow[8],
							'WEIGHT' => $arRow[23],
							'HEIGHT' => $arRow[24],
							'WIDTH' => $arRow[25],
							'VOLUME' => $arRow[26],
							'SKU' => $arRow[29],
							'PRICE' => $arRow[12],
							'STORE' => $arRow[15],
						];

						if ($tp) {

							if (!isset($items[$GUID])) {

								$item['GUID'] = $GUID;
								$item['NAME'] = $NAME;
								$item['TYPE'] = 'PARENT';

								$item = array_merge($item, $item_dop);
								$items[$GUID] = $item;

							}

							$item['GUID'] = $GUID_TP;
							$item['NAME'] = $NAME .  ' ('. trim($arRow[4]) .')';
							$item['TYPE'] = 'TP';
							$item['CML2'] = $GUID;

							$item = array_merge($item, $item_dop);
							$items[$GUID_TP] = $item;

						} else {

							$item['GUID'] = $GUID;
							$item['NAME'] = $NAME;
							$item['TYPE'] = 'SIMPLE';

							$item = array_merge($item, $item_dop);
							$items[$GUID] = $item;

						}

					}

				}
			}

		}

		return $items;

	}


	/*oknaaudio*/
	private function oknaaudio() {

		$this->productsFromCatalog = $this->getProductsFromCatalog();

		if ($this->type == 'update') {

			$el = new CIBlockElement;

			$this->productsFromParser  = $this->oknaaudioGetPricelistFromOkna();

			foreach ($this->productsFromParser as $article => $item) {
				if (isset($this->productsFromCatalog[$article])) {

					$productID = $this->productsFromCatalog[$article]['ID'];
					if (!empty($productID)) {

						$store = str_replace(['>','<','=','<=','>='], '', $item['STORE']);
						$this->updatePriceStore($productID, $article, $store, $item['PRICE']);

					}

				}
			}

		} else {

			$this->oknaaudioGetItemsFromSource();

		}

	}

	private function oknaaudioGetItemsFromSource() {

		$filenameOkna = 'https://okno-audio.ru/sitemap-iblock-53.xml'; // brands
		//$filenameOkna = 'https://ustage-group.ru/import/okno-audio_sitemap.xml';
		$oknaXmlData = $this->getDataCurl($filenameOkna);

		if ($oknaXmlData) {

			$filename = $this->parser .'_sitemap.xml';
			$this->toFile(__DIR__ .'/'. $filename, $oknaXmlData);

			if ($xmlObj = $this->getsrcfileToObject($filenameOkna)) {

				$el = new CIBlockElement;

				$this->brandsFromHL = $this->getDatasFromHL(2);
				$brands_exp = ['utsenennoe_oborudovanie'];

				foreach ($xmlObj->url as $k=>$item) {

					$url = (string)$item->loc;
					$locArray = explode('/', $url);
					$locArrayBrand = $locArray[4]; //brand

					if (count($locArray) == 6 && !in_array($locArrayBrand, $brands_exp)) {

						$productsUrl = $this->oknaaudioPrepareBrandFromUrl($url);

						$sleepi = 0;
						if (!empty($productsUrl)){
							foreach ($productsUrl as $productUrl){

								if ($sleepi % 20 == 0) {
									sleep(2);
								}

								$product = $this->oknaaudioPrepareProductFromUrl($productUrl);

								if (!empty($product['NAME']) && !empty($product['ARTICLE'])) {

									$productID = false;

									if (empty($this->productsFromCatalog) || !isset($this->productsFromCatalog[$product['ARTICLE']])) {

										$arLoadProductArray = [
											"NAME"              => $product['NAME'],
											"ACTIVE"            => 'N',
											"IBLOCK_SECTION" 	=> $this->sectionNew,
											"IBLOCK_ID"         => self::IBLOCK_ID,
											"CODE"              => \Cutil::translit($product['NAME'], 'ru', ['replace_other'=>'']),
											"PREVIEW_TEXT"       => $product['PREVIEW_TEXT'],
											"PREVIEW_TEXT_TYPE"  => 'HTML',
											"DETAIL_TEXT"       => $product['DETAIL_TEXT'],
											"DETAIL_TEXT_TYPE"  => 'HTML',
										];
										if (!empty($product['DETAIL_PICTURE'])) {
											$arLoadProductArray['DETAIL_PICTURE'] = $product['DETAIL_PICTURE'];
											$arLoadProductArray['PREVIEW_PICTURE'] = $product['DETAIL_PICTURE'];
										}

										$productID = $el->Add($arLoadProductArray);

										if ($productID) {

											CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [
												'UPLOADED_FROM_PAGE' => $this->domen . $productUrl,
												'CML2_ARTICLE' => $product['ARTICLE'],
												'MORE_PHOTO' => $product['PHOTOS'],
												'UPLOADED_PHOTO' => $product['DETAIL_PICTURE_URL'],
												'MANUFACTURER' => $locArrayBrand,
											]);
											$this->tolog($this->logs, 'Add product - '. $productID .';', true);

										} else {

											$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

										}

									}

								}

								$sleepi++;

							}
						}

					}

				}

			}


		}

	}

	private function oknaaudioPrepareProductFromUrl($url) {

		$product = [];

		if (!empty($url)) {

			$html = $this->getDataCurl($this->domen . $url);
			if (!empty($html)) {

				$doc = phpQuery::newDocument($html);

				$product['ID'] = '';

				$product['NAME'] = trim(pq($doc->find('h1'))->text());

				$product['PREVIEW_TEXT'] = trim(pq($doc->find('.detail-new__el_name'))->text());

				$product['DETAIL_TEXT'] = pq($doc->find('#tab_info article div'))->html();

				$product['ARTICLE'] = str_replace('Артикул: ', '', pq($doc->find('.detail-new__block-name .art'))->text());

				$product['DETAIL_PICTURE_URL'] = '';
				$product['PHOTOS'] = [];
				$dopImages = $doc->find('.product-detail-image-container .slideItem a');
				if ($dopImages) {
					foreach ($dopImages as $dopImage) {

						$urlImage = $this->domen . pq($dopImage)->attr('href');

						if (empty($product['DETAIL_PICTURE_URL'])) {
							$product['DETAIL_PICTURE_URL'] = $urlImage;
						}

						$product['PHOTOS'][] = CFile::MakeFileArray($urlImage);

					}
				}
				if (!empty($product['PHOTOS'])) {
					$product['DETAIL_PICTURE'] = $product['PHOTOS'][0];
					//unset($product['PHOTOS'][0]);
				}

			} else {

				$this->tolog($this->logsError, 'page error - '. $url.';', true);

			}

		}

		return $product;

	}

	private function oknaaudioPrepareBrandFromUrl($url, $page = false) {

		$productsUrl = [];

		$html = $this->getDataCurl($url);
		if (!empty($html)) {

			$doc = phpQuery::newDocument($html);

			$items = $doc->find('.prog-itemProduct');
			if (!empty($items)) {
				foreach ($items as $item) {

					$item = pq($item);
					$item_link = pq($item->find('div.item__description a'))->attr('href');
					if (!empty($item_link)) {
						$productsUrl[] = $item_link;
					}

				}
			}

			if (!$page) {

				$navLast = $doc->find('.page-navigation li.page:last');

				if (!empty($navLast)) {

					$navLast = trim(pq($navLast)->text());
					for ($page=2; $page<=$navLast; $page++) {

						$productsUrlNavs =  $this->oknaaudioPrepareBrandFromUrl($url .'?page='. $page, true);
						if (!empty($productsUrlNavs)) {
							$productsUrl = array_merge($productsUrl, $productsUrlNavs);
						}

					}

				}

			}

		}

		return $productsUrl;

	}

	private function oknaaudioGetPricelistFromOkna() {

		$items = [];

		$filenameOkna = $this->oknaaudioGetZIP();
		//$filenameOkna = __DIR__ . '/priceOkna.xls';

		if (!empty($filenameOkna) && $xls = SimpleXLS::parse($filenameOkna)) {
			foreach ($xls->rows() as $xlsRow) {

				$items[$xlsRow[0]] = [
					'NAME' => $xlsRow[1],
					'CODE' => $xlsRow[0],
					'PRICE' => (int)$xlsRow[4],
					'STORE' => $xlsRow[5],
				];

			}

		}

		return $items;

	}

	private function oknaaudioGetZIP() {

		$tmpPath = __DIR__;

		$zipPath = $tmpPath . '/priceOkna.zip';
        $unzippedXlsPath = $tmpPath . '/Price.xls';
        $xlsPath = $tmpPath . '/priceOkna.xls';

        $zip = file_get_contents('https://price.okno-audio.ru/Price.zip', false, stream_context_create([
            'http' => [
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]));

        if (!$zip) {
            return false;
        }

        file_put_contents($zipPath, $zip);

        if (!file_exists($zipPath)) {
            return false;
        }

		$zippy = Zippy::load();

        $zip = $zippy->open($zipPath);
        $zip->extract($tmpPath);

        if (!file_exists($unzippedXlsPath)) {
            return false;
        }

        rename($unzippedXlsPath, $xlsPath);

		return $xlsPath;

	}


	/*invask*/
	private function invask() {

		$this->productsFromCatalog = $this->getProductsFromCatalog();
		$this->productsFromParser = $this->invaskGetProductsFromSource();

	}

	private function invaskGetDataFromInvask() {

        $ch = curl_init();
        $array = [];
        $array['goods'] = [];
        $i = 0;
        $invaskToken = $this->getParserCredential('invask', 'token');

        if (empty($invaskToken)) {
            $this->tolog($this->logsError, 'Invask API token is not configured;', true);
            return $array;
        }

        while (true) {
		//while ($i<3000) {
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://invask.ru/api/client/v1/products?offset='.$i,
                CURLOPT_ENCODING => "",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer ". $invaskToken,
                    "content-type: application/json"
                ),
            ]);

            $response = curl_exec($ch);
            $response = json_decode($response, true);

            if (!$response) break;

            $array['total'] = $response['total'];
            $array['goods'] = array_merge($array['goods'], $response['products']);

            $i += 3000;
        }

        curl_close($ch);


        return $array;

	}

	private function invaskGetProductsFromSource() {

		$invaskData = $this->invaskGetDataFromInvask();

		if (!empty($invaskData)) {

			$filename = $this->location .'/'. $this->parser .'/check_'. date('Ymd') .'.txt';
			//$this->toFile(__DIR__ .'/'. $filename, $invaskData['goods']);

			$el = new CIBlockElement;

			/*sections on invask.ru*/
			$catalog_section = ['77', '61', '66', '67', '68', '160', '475', '513', //dj
			   '80', '976', '351', '875', '876', '458', '880', '885', '883', '879', '886', '884', '881', '882', '486', '325', '953', '348', '497', '349', '350', '490', '455', '476', '466', //mikrofony
			   '81', '188', '870', '487', '952', '502', '969', '951', '872', '893', '894', '56', '943', '967', '942', '944', '968', '315', '168', '945', '948', '946', '947', '14', '293', '341', '342', '113', '391', '949', '138', '518', '519', '147', '520', '887', '172', '182', '448', '950', '223', '344', '23', '73', '238', '389', '345', '257', '262', '125', '395', // svet
			   '86', '243', '297', '173', '29', '384', '355', '354', '260', '385', '383', '382', '298', '386', '146', '474', '116', '871', '247', '121', '122', '112', '111', '456', '356', '208', '30', '202', '203', '261', '174', '190', '379', '123', '387', '873', '955', '128', '127', '157', '158', '159', '509', '295', '858', '201', '965', '186', '105', '107', '488', '958', '377', '124', '957', '126', '956', '378', '960', '117', '255', '962', // kabeli
			   '79', '299', '132', '131', '443', '512', '346', '210', '324', '264', '265', '263', '471', '291', '26', '329', '330', '331', '332', '333', '971', '334', '335', '336', '246', '337', '447', '313', '236', '954', '495', '496', '9', '50', '980', '314', '136', '106', '437', '185', '137', '200', '4', '392', '227', '292', '489', '281', '496', '423', '221', '276', '8', // zvuk
			   '84', '51', '24', '286', '151', '153', '220', '152', '231', '25', '92', '91', // translyatory
			   '426', '457', '431', '430', '429', '432', '428', '427', // naushniki
			   '239, 28, 515, 514, 415' // check
			];

			foreach ($invaskData['goods'] as $product) {

				$this->tolog($filename, 'product CHECK - '. $product['name'] .' - '. $product['cat_number'] .' - '. $product['category_id'] .' - '. $this->sectionNew .' - '. $product['quantityLabel'] .' - '. $product['regular_price'] .';', true);

				if (!in_array($product['category_id'], $catalog_section)) {
					continue;
				}

				$sku = $product['cat_number'];
				if (empty($this->productsFromCatalog) || !isset($this->productsFromCatalog[$sku])) {
					if ($this->type == 'add') {

						$arLoadProductArray = [
							"NAME"              => $product['name'],
							"ACTIVE"            => 'N',
							"IBLOCK_SECTION" 	=> $this->sectionNew,
							"IBLOCK_ID"         => self::IBLOCK_ID,
							"CODE"              => \Cutil::translit($product['name'], 'ru', ['replace_other'=>'']),
						];
						if (!empty($product['originalImageUrl'])) {
							$arLoadProductArray['DETAIL_PICTURE'] = CFile::MakeFileArray(trim($product['originalImageUrl']));
							$arLoadProductArray['PREVIEW_PICTURE'] = $arLoadProductArray['DETAIL_PICTURE'];
						}

						$productID = $el->Add($arLoadProductArray);

						if ($productID) {

							CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [
								'UPLOADED_FROM_PAGE' => $this->domen .'product/' . $sku,
								'CML2_ARTICLE' => $sku,
								'BRAND' => $product['brand_name'],
								'MODEL' => $product['model'],
								'UPLOADED_PHOTO' => $product['originalImageUrl'],
							]);
							$this->tolog($this->logs, 'Add product - '. $productID .';', true);

						} else {

							$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

						}

					}
				} else {

					$productID = $this->productsFromCatalog[$sku]['ID'];

				}

				if (!empty($productID)) {

					$store = str_replace(['>','<','=','<=','>='], '', $product['quantityLabel']);

					$this->updatePriceStore($productID, $sku, $store, $product['regular_price']);

				}

			}

		}

	}


	/*imlight*/

	private function imlight() {

		$this->apitoken = $this->imlightGetToken();
		$imlightPrice = $this->imlightGetPrice();
		if (empty($imlightPrice)) {
			$this->tolog($this->logsError, 'Imlight import aborted: price file was not received;', true);
			return;
		}

		$this->productsFromParser = $this->imlightGetProductsFromSource($imlightPrice);
		if (empty($this->productsFromParser)) {
			$this->tolog($this->logsError, 'Imlight import aborted: price file contains no products;', true);
			return;
		}

		$this->productsFromCatalog = $this->getProductsFromCatalog();

		$el = new CIBlockElement;
		$newProducts = [];

		foreach ($this->productsFromParser as $article => $item) {
			if (isset($this->productsFromCatalog[$article])) {

				$productID = $this->productsFromCatalog[$article]['ID'];
				if (!empty($productID)) {

					$this->updatePriceStore($productID, $article, $item['STORE'], $item['PRICE']);

				}

			} else {

				$newProducts[] = $article;

			}
		}

		if ($this->type == 'add' && !empty($newProducts)) {

			$newProductsData = $this->imlightGetProducts($newProducts);
			if (!empty($newProductsData)) {
				foreach ($newProductsData as $item) {

					$arLoadProductArray = [
						"NAME"           => $item['product_name_print'],
						"ACTIVE"		 => 'N',
						"IBLOCK_SECTION" => $this->sectionNew,
						"IBLOCK_ID"		 => self::IBLOCK_ID,
						"CODE"			 => \Cutil::translit($item['product_name_print'], 'ru', ['replace_other'=>'']),
						"DETAIL_TEXT"	 => str_replace(' / ', '<br>', $item['product_text']),
						"DETAIL_TEXT_TYPE" => 'HTML',
					];

					if (!empty($item['images']) && !empty($item['images'][0]['image'])) {

						$photo = $item['images'][0]['image'];
						$arLoadProductArray['DETAIL_PICTURE'] = CFile::MakeFileArray(trim($photo));
						$arLoadProductArray['PREVIEW_PICTURE'] = $arLoadProductArray['DETAIL_PICTURE'];

					}

					$productID = $el->Add($arLoadProductArray);

					if ($productID) {

						CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [
							'UPLOADED_FROM_PAGE' => $this->domen .'check-url-from-site/',
							'CML2_ARTICLE' => $item['product_code_vendor'],
							'UPLOADED_PHOTO' => isset($photo) ? $photo : '',
							'COUNTRY' => $item['product_country'],
							'PARSER_PRODUCT_CODE' => $item['product_code'],
						]);
						$this->tolog($this->logs, 'Add product - '. $productID .';', true);

					} else {

						$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

					}

				}
			}


		}

	}

	private function imlightGetProductsFromSource($filename) {

		$items = [];

		if ($filename && $xlsx = SimpleXLSX::parse(__DIR__ .'/'. $filename)) {
			foreach ($xlsx->rows() as $xlsxRow) {

				if (empty($xlsxRow[0]) || empty($xlsxRow[3])) {
					continue;
				}

				$items[$xlsxRow[0]] = [
					'NAME' => $xlsxRow[3],
					'PRICE' => (int)$xlsxRow[4],
					'STORE' => $xlsxRow[14],
				];

			}

		} else {
			$this->tolog(
				$this->logsError,
				$filename ? 'Imlight price file parse failed;' : 'Imlight price file was not received;',
				true
			);
		}

		return $items;

	}

	private function imlightGetProducts($code) {

		$products = [];

		if ($this->apitoken && $code) {

			$url = 'https://b2b.imlight.ru/api/v1.0/products/get/';
			$params = [
				"token" => $this->apitoken,
				"filter_product_code" => implode(',', $code),
			];
			$response = $this->imlightCurlPost($url, $params);

			if (!$response['error'] && $response['data']) {

				$products = $response['data'];

			}

		}

		return $products;

	}

	private function imlightGetPrice() {

		if ($this->apitoken) {

			$url = 'https://b2b.imlight.ru/api/v1.0/pricelist/get/';
			$params = [
				"token" => $this->apitoken,
				"format" => "xlsx",
				"is_archive" => 0
			];
			$response = $this->imlightCurlPost($url, $params);

			if (!$response['error'] && $response['file_content']) {

				$imlightXlsData = $response['file_content'];

				$filename = $this->parser .'_ostatki.xlsx';
				$this->toFile(__DIR__ .'/'. $filename, base64_decode($imlightXlsData));

				return $filename;

			}

			$this->logImlightApiError('pricelist/get', $response);

		}

		return false;

	}

	private function imlightGetToken() {

		$token = false;
		$login = $this->getParserCredential('imlight', 'login');
		$password = $this->getParserCredential('imlight', 'password');

		if (empty($login) || empty($password)) {
			$this->tolog($this->logsError, 'Imlight API credentials are not configured;', true);
			return false;
		}

		$url = 'https://b2b.imlight.ru/api/v1.0/auth/';
		$params = [
			"login" => $login,
			"password" => $password,
		];
		$response = $this->imlightCurlPost($url, $params);

		if (!$response['error'] && $response['token']) {
			$token = $response['token'];
		} else {
			$this->logImlightApiError('auth', $response);
		}

		return $token;

	}

	private function imlightCurlPost($url, $params) {

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_HEADER => false,
			CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
			CURLOPT_POSTFIELDS => json_encode($params, JSON_UNESCAPED_UNICODE),
			CURLOPT_CONNECTTIMEOUT => 20,
			CURLOPT_TIMEOUT => 60,
		]);
		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$curlError = curl_error($curl);
		curl_close($curl);

		if ($response === false) {
			$this->tolog($this->logsError, 'Imlight API transport error: '. $curlError .';', true);
			return ['error' => true, 'error_code' => $httpCode];
		}

		$response = json_decode($response, true);
		if (!is_array($response)) {
			$this->tolog($this->logsError, 'Imlight API returned invalid JSON; HTTP '. $httpCode .';', true);
			return ['error' => true, 'error_code' => $httpCode];
		}

		return $response;

	}

	private function logImlightApiError($method, $response) {

		$errorCode = isset($response['error_code']) ? (int)$response['error_code'] : 0;
		$errorMessage = trim((string)($response['error_message'] ?? $response['message'] ?? 'unknown error'));

		$this->tolog(
			$this->logsError,
			'Imlight API '. $method .' failed; code '. $errorCode .'; '. $errorMessage .';',
			true
		);

	}

	private function getParserCredential($parser, $key) {

		if ($this->parserCredentials === null) {
			$this->parserCredentials = [];
			$credentialsFile = getenv('USTAGE_PARSER_CREDENTIALS_FILE');

			if (empty($credentialsFile)) {
				$credentialsFile = dirname($_SERVER['DOCUMENT_ROOT']) .'/.parser_credentials.php';
			}

			if (is_file($credentialsFile)) {
				$credentials = include $credentialsFile;
				if (is_array($credentials)) {
					$this->parserCredentials = $credentials;
				}
			}
		}

		return $this->parserCredentials[$parser][$key] ?? '';

	}

	/*slami*/

	private function slami() {

		$el = new CIBlockElement;

		$this->productsFromCatalog = $this->getProductsFromCatalog();
		$this->productsFromUstage = $this->slamiGetProductsFromUstage();
		$this->productsFromParser = $this->slamiGetPricelistFromSlami();

		if ($this->type == 'add') {

			$this->slamiGetSitemapFromSlami();


		} else {

			foreach ($this->productsFromParser as $article => $item) {
				if (isset($this->productsFromUstage[$article]) && isset($this->productsFromCatalog[$article])) {

					$productID = $this->productsFromCatalog[$article]['ID'];
					if (!empty($productID) && $this->productsFromCatalog[$article]['SECTION'] != $this->sectionNew) {

						$this->updatePriceStore($productID, $article, $item['STORE'], $item['PRICE']);

					}

				}
			}

		}

	}

	private function slamiGetSitemapFromSlami() {

		$filenameSlami = 'https://slami.ru/sitemap-iblock-17.xml';
		//$filenameSlami = 'https://ustage-group.ru/import/slami_sitemap.xml';
		$slamiXmlData = $this->getDataCurl($filenameSlami);

		if ($slamiXmlData) {

			$filename = $this->parser .'_sitemap.xml';
			$this->toFile(__DIR__ .'/'. $filename, $slamiXmlData);

			if ($xmlObj = $this->getsrcfileToObject($filenameSlami)) {

				$el = new CIBlockElement;

				/*unused sections on slami.ru*/
				$catalog_section_exp = [
					'G0', 'A0', 'JT', 'GA', 'PK', '5N', '7R', 'Z1', '5H', 'ME', 'I0', 'PF', 'PJ', '5B', 'N3', 'LP', 'M9', 'M8', 'B0', '2F', '2G', '2Q', 'PH', '2L', 'Z0', '8J', 'NL', 'M2', 'NF', 'HB', 'M0', '15', 'N2', '13', '01', 'B5', 'D1', 'Q7', 'D0', 'N5', 'A8', 'N0',	'B8', '6G', 'D7', 'R0', 'J7', 'PU', 'R2', 'R6', 'J0', '52', 'K3', 'J6', 'NN', 'NP', '53', 'B1', 'H9', '35', '09', 'J2', 'H0', 'J3', 'B6', 'D8', 'K5', 'L1', 'L8', 'K7', 'L6', '27', 'X6', 'L9', 'Z4', 'L0', 'KK', 'FN', 'LQ', '5K', '5L', 'C3', '1F', 'NY', 'C2', 'Z3', 'N7', 'PR', 'QK', 'N9', 'PT', 'QE', '56', '58', '59', 'M1', 'N8', 'PS', 'QD', 'Q5', '3I', '4I', '5I', 'RD',
					'2V', 'U9', 'U0', '6H', 'I1', 'W9', 'BR', 'Y4', 'Y6', 'BF', 'BA', 'BC', 'BE', '3V', 'AZ', '3Z', '6Z', '3W', 'AX', 'AY', '4A', '7X', 'LL', '3Y', 'Y0', '7E', '5W', '5Y', 'U1', '5T', '7B', 'U2', 'GK', 'GM', 'U3', 'LM', 'GP', 'PY', 'AS', 'Y3', '30', 'AW', '12', '1X', 'AU', 'AV', 'DA', '5U', '2B', '2N', 'QF', '3E', '0Y', 'GV', '0U', 'GY', 'I2', '2X', '7Y', 'Y1', 'PX', 'R8', 'T6', 'T4', 'R9', 'GZ', 'T3', '0H', 'GW', '0J', '0C', 'T7', '4D', '4E', '4F', '4G', '0K', '0X', '0Z', '0L', '0O', 'LK', '0P', '0A', 'T9', 'GS', 'GU', 'JV', 'GT', 'FD', 'T0', 'FE', 'R3', 'R4', 'R5', 'FI', 'FG', '3L',  'FH', 'S0', '5C', 'BH', '5P', '5M', '64', '6W', 'BZ', '7M', 'U4', 'B4', '7N', '5O', '5X', 'BL', 'B9', '7Q', '5D', '5G', '84', '5F', '9J', 'U7', 'I4',
					'B7', 'W5', 'KS', '2Y', '2O', '70', '2P', 'KP', '2H', 'AE', '2K', '1M', '1L', '2Z', '74', 'KQ', 'PM', '2C', 'QM', 'JP', 'JR', '2T', 'JQ', 'MI', '3N', 'QX', '4U', '4P', '86', '3M', '7I', 'MF', 'E9', '9A', '98', 'HP', 'HU', 'HR', '99', 'HS', 'E7', 'E8', '90', 'JM', 'K1', 'W2', 'W6', 'JG', 'W4', 'JH', '91', '3J', 'JB', '9L', '66', 'JD', '75', '73', 'HY', '3K', 'HX', 'MH', 'HZ', 'JE', 'E3', 'HV', 'E4', 'E5', 'BD', 'JA', 'W3', 'KR', 'HN', 'W0', 'E2', 'S9', 'T1', 'T2', 'T5', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', '89', 'S1', 'HW', 'JS', '5R', '79', 'B3', '3D', '3G', '3F', 'QR', 'JK', 'PD', '3O', '3A', '3P', 'JL', 'JJ', '3H', 'O0', '9H', '0E', '0T', 'Q8', 'MA', 'MQ', 'Q1', 'K9', 'Q4', '08', '7Z', '8T', 'K6', '8Y', '8S', '8X', '8C', '8V', '9W', 'W1', 'L7', 'MG', 'K4', 'MJ', '8U', 'MB',
					'US', 'AB', 'AF', 'AG', 'AM', 'AH', 'AD', 'AQ', 'AR', 'AO', 'AI', 'A1', 'AE',
					'T8', '6Y',
					'E0', 'H3', 'H7', 'H5', 'H8', 'LS', 'H4', '8A', '6D', '6E', 'KX', 'M3', 'M4', '9P', 'F7', 'F9', 'E6', '72', '71', 'F0', 'G3', '38', '37', '3X', 'G7', 'H1', 'H2', '39',
					''
				];

				foreach ($xmlObj->url as $item) {
					if (!empty($item->loc)) {

						$url = str_replace('http:', 'https:', (string)$item->loc);
						$locArray = explode('/', $url);
						$locArrayCount = count($locArray);
						$locArraySection = $locArray[$locArrayCount-3];
						$locArrayArticle = str_replace('CNT', '', $locArray[$locArrayCount-2]);

						if ($locArrayCount == 7 && !in_array($locArraySection, $catalog_section_exp)) {

							if (!empty($this->productsFromCatalog) && isset($this->productsFromCatalog[$locArrayArticle])) {

								/*$this->updateProductProp($this->productsFromCatalog[$locArrayArticle]['ID'], 'UPLOADED_FROM_PAGE', $url);
								$this->tolog($this->logs, 'Update product - '. $this->productsFromCatalog[$locArrayArticle]['ID'] .';', true);*/

							} else {

								$product = $this->slamiPrepareProductFromUrl($url);

								if (!empty($product['ARTICLE']) && !empty($this->productsFromCatalog) && isset($this->productsFromCatalog[$product['ARTICLE']])) {

									/*$this->updateProductProp($this->productsFromCatalog[$product['ARTICLE']]['ID'], 'UPLOADED_FROM_PAGE', $url);
									$this->tolog($this->logs, 'Update product - '. $this->productsFromCatalog[$product['ARTICLE']]['ID'] .';' .$url.';', true);*/

								} else {

									if (!empty($product['NAME'])) {

										$arLoadProductArray = [
											"NAME"              => $product['NAME'],
											"ACTIVE"            => 'N',
											"IBLOCK_SECTION" 	=> $this->sectionNew,
											"IBLOCK_ID"         => self::IBLOCK_ID,
											"CODE"              => \Cutil::translit($product['NAME'], 'ru', ['replace_other'=>'']),
											"DETAIL_TEXT"       => $product['DETAIL_TEXT'],
											"DETAIL_TEXT_TYPE"  => 'HTML',
										];
										if (!empty($product['DETAIL_PICTURE'])) {
											$arLoadProductArray['DETAIL_PICTURE'] = CFile::MakeFileArray(trim($this->domen . $product['DETAIL_PICTURE']));
										}

										$productID = $el->Add($arLoadProductArray);

										if ($productID) {

											CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, ['UPLOADED_FROM_PAGE' => $url, 'CML2_ARTICLE' => 'S-'.$locArrayArticle]);

											$this->tolog($this->logs, 'Add product - '. $productID .';', true);

										} else {

											$this->tolog($this->logsError, 'Add product ERROR - '. $arLoadProductArray['NAME'] .' - ERROR: ' .$el->LAST_ERROR .';', true);

										}

									}

								}

							}

						}

					}

				}

			}

		}

	}

	private function slamiPrepareProductFromUrl($url) {

		$product = [];

		if (!empty($url)) {

			$html = $this->getDataCurl($url);
			if (!empty($html)) {

				$doc = phpQuery::newDocument($html);

				$product['ID'] = '';

				$product['NAME'] = pq($doc->find('h1'))->text();

				$product['PRICE'] = $this->clearStr(pq($doc->find('.priceblock .price .value'))->text());

				$product['ARTICLE'] = $this->clearStr(pq($doc->find('.code .code'))->text());

				$detailText = pq($doc->find('.good_details .description'))->html();
				if (!empty($detailText)) {

					$detailText = explode('<div id="where-buy"', $detailText)[0];
					$detailText = explode('<div class="alsosimilar"', $detailText)[0];

					$product['DETAIL_TEXT'] = trim(strip_tags($detailText, ['p', 'br']));

				}

				$image = $doc->find('.good_details .photo a.image-wrapper');
				if (!empty($image)) {
					$product['DETAIL_PICTURE'] = pq($image)->attr('href');
				}

			} else {

				$this->tolog($this->logsError, 'page error - '. $url.';', true);

			}

		}

		return $product;

	}

	private function slamiGetPricelistFromSlami() {

		$items = [];

		$filenameSlami = 'https://dealer.slami.ru/info/pricelist.csv';
		$slamiPriceData = $this->getDataCurl($filenameSlami);

		if ($slamiPriceData) {

			$filename = __DIR__ .'/'. 'slami_pricelist.csv';
			$slamiPriceData = iconv('Windows-1251', 'UTF-8', $slamiPriceData);
			$this->toFile($filename, $slamiPriceData);

			if (($f = fopen($filename, 'r')) !== FALSE) {
				while (($csvRow = fgetcsv($f, 10000, ';')) !== false) {

					$price = $this->slamiCheckPrice((int)$csvRow[8], (int)$csvRow[10]);

					if ($price) {
						$items[$csvRow[12]] = [
							'NAME' => $csvRow[7],
							'CODE' => $csvRow[5],
							'PRICE' => $price,
							'STORE' => (int)$csvRow[11],
						];
					}

				}
			}

		}

		return $items;

	}

	private function slamiCheckPrice($priceRoznica, $priceDiller) {

		$price = false;

		if ($priceRoznica > 0 && $priceDiller > 0) {

			$discount = $priceDiller/$priceRoznica;
			if ($discount <= 0.8) {
				$price = $priceRoznica;
			}

		}

		return $price;

	}

	private function slamiGetProductsFromUstage() {

		$items = [];

		$filename = __DIR__ .'/'. 'sl_price_ustage_utf8.csv';
		if (($f = fopen($filename, 'r')) !== FALSE) {
			while (($csvRow = fgetcsv($f, 10000, ';')) !== false) {

			  $items[$csvRow[12]] = [
				'NAME' => $csvRow[7],
				'CODE' => $csvRow[5],
			  ];

			}
		}

		return $items;

	}

	/**/

	private function updatePriceStore($productID, $article, $store, $price, $onlyprice=false, $offer=false) {

		if (!empty($productID)) {

			$el = new CIBlockElement;

			if (!$onlyprice) {
				$store = (int)$store;
				$this->updateStore($productID, $store);
			} else {
				$store = 0;
			}

			$price = (int)$price;
			if (empty($this->productsFromCatalog[$article]['PRICE_FROZEN'])) {
				$this->updatePrice($productID, $price, $offer);
			}

			if ($store>0 || $price>0) {
				$el->Update($productID, ['ACTIVE' => 'Y']);
			}

			$this->productsUpdate[] = $productID;

			if (!$offer) {
				CIBlockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, ['POSTAVSHCHIK' => $this->parserHLID]);
			}


			if ($this->type == 'update') {

				$this->tolog($this->logs, 'Update '. ($offer?'offer':'product') .' - '. $productID .';' .$price.';' .$store. ';', true);

			}

		}

		return;

	}

	private function getDatasFromList($CODE, $IBLOCK_ID=self::IBLOCK_TP_ID) {

		$info = [];

		$propValues = \Bitrix\Iblock\PropertyEnumerationTable::getList([
			'select' => ['ID', 'VALUE', 'XML_ID'],
			'filter' => [
				'PROPERTY.IBLOCK_ID' => $IBLOCK_ID,
				'PROPERTY.CODE' => $CODE
			]
		])->fetchAll();
		foreach ($propValues as $propValue) {
			$info[$propValue['VALUE']] = $propValue['ID'];
		}

		return $info;

	}

	private function getDatasFromHL($idHL) {

		$arHL = [];

		\Bitrix\Main\Loader::IncludeModule('highloadblock');
        $blockHL = \Bitrix\Highloadblock\HighloadBlockTable::getById($idHL)->fetch();
        $entityHL = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($blockHL);
		$entityClassHL = $entityHL->getDataClass();

		if ($entityClassHL) {

			$dataEntityClassHL = $entityClassHL::getList([
				'select' => ['*'],
				'order'  => ['UF_NAME' => 'ASC'],
				'filter' => [],
			]);
			while ($resultHL = $dataEntityClassHL->fetch()) {
				$arHL[$resultHL['UF_NAME']] = [
					'ID' => $resultHL['ID'],
					'NAME' => $resultHL['UF_NAME'],
					'XML_ID' => $resultHL['UF_XML_ID'],
				];
			}

		}

		return $arHL;

	}


	private function getOffersFromCatalog($PARENT_ID) {

		$items = [];

		$dbItems = \Bitrix\Iblock\Elements\ElementOffersTable::getList([
			'select' => ['ID', 'NAME', 'CML2_LINK_'=>'CML2_LINK', 'GUID_'=>'GUID', 'CML2_ARTICLE_'=>'CML2_ARTICLE'],
			'filter' => [
				'IBLOCK_ID' => self::IBLOCK_TP_ID,
				'CML2_LINK.VALUE' => $PARENT_ID,
			],
			'order' => ['SORT' => 'ASC'],
			'cache' => ['ttl' => 3600]
		])->fetchAll();
		foreach ($dbItems as $item) {

			$sku = $item['CML2_ARTICLE_VALUE'];

			if ($this->parser == 'anzhee') {
				//$sku = str_replace('S-', '', $item['CML2_ARTICLE_VALUE']);
				$sku = $item['GUID_VALUE'];
			}

			if (!empty($sku)) {
				$items[$sku] = [
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'GUID' => $item['GUID_VALUE'],
					'PARENT' => (int)$item['CML2_LINK_VALUE'],
				];
			}
		}

		return $items;

	}

	private function getProductsFromCatalog($byUrl=false) {

		$items = [];

		$domenCheck = str_replace(['http://', 'https://', 'www.'], '', $this->domen);

		$dbItems = \Bitrix\Iblock\Elements\ElementCatalogTable::getList([
			'select' => ['ID', 'NAME', 'IBLOCK_SECTION_ID', 'UPLOADED_FROM_PAGE_'=>'UPLOADED_FROM_PAGE', 'CML2_ARTICLE_'=>'CML2_ARTICLE', 'PRICE_FROZEN_'=>'PRICE_FROZEN', 'GUID_'=>'GUID', 'PARSER_PRODUCT_CODE_'=>'PARSER_PRODUCT_CODE'],
			'filter' => [
				'IBLOCK_ID' => self::IBLOCK_ID,
				'UPLOADED_FROM_PAGE.VALUE' => '%'. $domenCheck .'%',
				//'!IBLOCK_SECTION_ID' => $this->sectionNew,
			],
			'order' => ['SORT' => 'ASC'],
			'cache' => ['ttl' => 3600]
		])->fetchAll();
		foreach ($dbItems as $item) {
			//if ($item['IBLOCK_SECTION_ID'] !== $this->sectionNew) {

				$sku = $item['CML2_ARTICLE_VALUE'];

				if ($this->parser == 'slami') {
					$sku = str_replace('S-', '', $sku);
				} else if ($this->parser == 'anzhee') {
					$sku = $item['GUID_VALUE'];
				} else if ($this->parser == 'imlight') {
					$sku = $item['PARSER_PRODUCT_CODE_VALUE'];
				}

				if ($byUrl) {

					if (!empty($item['UPLOADED_FROM_PAGE_VALUE'])) {
						$items[str_replace('http:', 'https:', $item['UPLOADED_FROM_PAGE_VALUE'])] = [
							'ID' => $item['ID'],
							'NAME' => $item['NAME'],
							'SECTION' => $item['IBLOCK_SECTION_ID'],
							'PAGE' => $item['UPLOADED_FROM_PAGE_VALUE'],
							'PRICE_FROZEN' => $item['PRICE_FROZEN_VALUE'],
						];

						$this->productsToDeactivate[] = $item['ID'];
					}

				} else {

					if (!empty($sku)) {
						$items[$sku] = [
							'ID' => $item['ID'],
							'NAME' => $item['NAME'],
							'SECTION' => $item['IBLOCK_SECTION_ID'],
							'PAGE' => $item['UPLOADED_FROM_PAGE_VALUE'],
							'PRICE_FROZEN' => $item['PRICE_FROZEN_VALUE'],
						];

						$this->productsToDeactivate[] = $item['ID'];
					}
				}


			//}
		}

		return $items;

	}

	private function updateProductProp($productID, $propName, $propValue) {

		CIblockElement::SetPropertyValuesEx($productID, self::IBLOCK_ID, [$propName => $propValue]);

	}

	private function deactivatedProducts($productArray) {

		foreach ($productArray as $productID) {

			CCatalogStoreProduct::UpdateFromForm([
				'PRODUCT_ID' => $productID,
				'STORE_ID' => 0, //Удаленный склад
				'AMOUNT' => 0
			]);

		}

		$this->deactivatedProductsFromSectionNew();

	}

	private function deactivatedProductsFromSectionNew() {

		if (!empty($this->sectionNew)) {

			$el = new CIBlockElement;

			$arFilter = [
				"IBLOCK_ID" => self::IBLOCK_ID,
				"SECTION_ID" => $this->sectionNew,
				"INCLUDE_SUBSECTIONS" => "Y",
				"PROPERTY_UPLOADED_FROM" => '%'. $this->domen .'%',
			];
			$itemsAr = CIBlockElement::GetList(
				["ID" => "ASC"],
				$arFilter,
				false,
				false,
				["ID"]
			);
			while ($item = $itemsAr->GetNext()) {

				$el->Update($item['ID'], ['ACTIVE' => 'N']);

			}

		}

		return;

	}

	private function updateStore($productID, $store = 0, $storeID = 5) {

		global $DB;

		if (!empty($productID)) {

			$store = (int)$store;

			$arFieldsStore = [
				'ID' => $productID,
				'AVAILABLE' => ($store > 0 ? 'Y' : 'N'),
				//'AVAILABLE' => 'Y',
				'QUANTITY' => $store
			];
			/*if (!CCatalogProduct::Add($arFieldsStore)) {
				CCatalogProduct::Update($productID, $arFieldsStore);
			}*/

			CCatalogStoreProduct::UpdateFromForm([
				'PRODUCT_ID' => $productID,
				'STORE_ID' => $storeID, //Удаленный склад
				'AMOUNT' => $store
			]);

		}

	}

	private function updatePrice($productID, $price = 0, $offer=false, $parentID=false) {

		if (!empty($productID)) {

			$PRICE_TYPE_ID = 1;
			$IBLOCK_ID = $offer !== false ? self::IBLOCK_TP_ID : self::IBLOCK_ID;

			$arFieldsPrice = [
				"PRODUCT_ID"       => $productID,
				"CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
				"PRICE"            => $price,
				"CURRENCY"         => 'RUB',
				"QUANTITY_FROM"    => false,
				"QUANTITY_TO"      => false
			];
			$resPrice = CPrice::GetList(
				[],
				[
					"PRODUCT_ID"       => $productID,
					"CATALOG_GROUP_ID" => $PRICE_TYPE_ID
				]
			);

			if ($arrPrice = $resPrice->Fetch()) {
				CPrice::Update($arrPrice['ID'], $arFieldsPrice);
			} else {
				CPrice::Add($arFieldsPrice);
			}

			CIBlockElement::SetPropertyValuesEx($productID, $IBLOCK_ID, ['MINIMUM_PRICE' => $price]);
			CIBlockElement::SetPropertyValuesEx($productID, $IBLOCK_ID, ['MAXIMUM_PRICE' => $price]);

		}

	}

	private function getParserFromHL() {

		$parser = false;

		\Bitrix\Main\Loader::includeModule('highloadblock');

		$hlTable = \Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['TABLE_NAME' => 'b_hlbd_postavshchiki']]);
		if ($arHL = $hlTable->Fetch()) {

			$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHL['ID']);
			$class = $entity->getDataClass();

			$result = $class::getList([
				'select' => ['ID', 'UF_NAME', 'UF_URL', 'UF_URL', 'UF_SECTION', 'UF_XML_ID', 'UF_CODE'],
				'filter' => ['!UF_URL' => false, 'UF_CODE' => $this->parser],
				'limit'  => 1,
			]);
			if ($item = $result->fetch()) {

				$this->parserHLID = $item['UF_XML_ID'];
				$this->domen = $item['UF_URL'];
				$this->sectionNew = $item['UF_SECTION'];

				$parser = true;

			}

		}

		return $parser;
	}

	/**/

	private function getFileContent($url) {

		$data = file_get_contents($url);

		if (empty($data) || strlen($data) < 10) {
			return false;
		}

		return $data;

	}

	private function tolog($url, $text, $add = true) {
		if (!$add) {
			file_put_contents($url, $text . PHP_EOL);
		} else {
			file_put_contents($url, date("d.m.Y G:i:s") . ";" . $text . PHP_EOL, FILE_APPEND);
		}
		return;
	}

	private function toFile($url, $text) {

		file_put_contents($url, $text);

		return;
	}

	private function fileName() {
		return 'import_'.$this->postavshik.'_'.date('Ymd').'_';
	}

	private function iconvp($str, $reverse = false) {
		if (!$reverse) {
			return iconv("UTF-8", "CP1251", $str);
		} else {
			return iconv("CP1251", "UTF-8", $str);
		}
	}

	private function clearStr($str, $repl = ['']) {
		return trim(str_replace([' ','₽',' р', ':', '&nbsp;', '\xc2\xa0', '(', ')'], $repl, $str));
	}


	private function getDataCurl($url, $type='html') {

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);

		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($httpcode != 200) {

			$this->tolog($this->logsError, ' Curl status for '. $url .': '. $httpcode .';', true);
			$this->tolog($this->logsError, ' Curl error for '. $url .': '. curl_error($ch) .';', true);

			return false;
		}

		return $data;

	}

    private function getsrcfileToObject($file) {
        return simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOCDATA);
    }


}


echo '<br />update ok';



?>
