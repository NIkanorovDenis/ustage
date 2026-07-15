<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true){
    die();
    
}
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);


return array (
    'parent' => 'car-repair-shop',
    'code' => 'bxready24/car-repair-shop',
    'name' => Loc::getMessage('LANDING_DEMO_BXREADY24_CAR_REPAIR_SHOP_TITLE'),
    'description' => Loc::getMessage(''),
    'show_in_list' => 'Y',
    'version' => 2,
    'preview' => 'https://cdn.bxready.ru/pictures/bxready24_template/7ad3240cf873b239916ab0da5dc9f15a.jpg',
    'preview_url' => '',
    'fields' => array (
        'ADDITIONAL_FIELDS' => array(
            'METAOG_IMAGE' => 'https://cdn.bxready.ru/pictures/bxready24_template/7ad3240cf873b239916ab0da5dc9f15a.jpg',
            'THEME_CODE' => 'spa',
            'METAOG_TITLE' => Loc::getMessage('LANDING_DEMO_BXREADY24_CAR_REPAIR_SHOP_TITLE'),
            'METAOG_DESCRIPTION' => Loc::getMessage('LANDING_DEMO_BXREADY24_CAR_REPAIR_SHOP_DESCRIPTION'),
            'METAMAIN_TITLE' => Loc::getMessage('LANDING_DEMO_BXREADY24_CAR_REPAIR_SHOP_TITLE'),
            'METAMAIN_DESCRIPTION' => Loc::getMessage('LANDING_DEMO_BXREADY24_CAR_REPAIR_SHOP_DESCRIPTION'),
            'HEADBLOCK_USE' => 'N',
            'TPL_REF' => 'Y',
            'TPL_ID' => '1'
        )
    ),
    'layout' => 
    array (
    ),
    'items' => array (
  '#block908' => 
  array (
    'old_id' => 908,
    'code' => '0.menu_17_restaurant',
    'cards' => 
    array (
      '.landing-block-node-menu-list-item' => 8,
    ),
    'nodes' => 
    array (
      '.landing-block-node-menu-list-item-link' => 
      array (
        0 => 
        array (
          'href' => '#',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Главная',
        ),
        1 => 
        array (
          'href' => '#block911',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Преимущества',
        ),
        2 => 
        array (
          'href' => '#block912',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Акции',
        ),
        3 => 
        array (
          'href' => '#block913',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Промо',
        ),
        4 => 
        array (
          'href' => '#block916',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Каталог',
        ),
        5 => 
        array (
          'href' => '#block922',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'О нас',
        ),
        6 => 
        array (
          'href' => '#block923',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Партнеры',
        ),
        7 => 
        array (
          'href' => '#block925',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Отзывы',
        ),
      ),
      '.landing-block-node-menu-logo-link' => 
      array (
        0 => 
        array (
          'href' => '#',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '
					
				',
        ),
      ),
      '.landing-block-node-menu-logo' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/936f71b1adfccd4fc6977c27424eec69.png',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-menu-list-item-link' => 
      array (
        0 => 'landing-block-node-menu-list-item-link nav-link p-0',
        1 => 'landing-block-node-menu-list-item-link nav-link p-0',
        2 => 'landing-block-node-menu-list-item-link nav-link p-0',
        3 => 'landing-block-node-menu-list-item-link nav-link p-0',
        4 => 'landing-block-node-menu-list-item-link nav-link p-0',
        5 => 'landing-block-node-menu-list-item-link nav-link p-0',
        6 => 'landing-block-node-menu-list-item-link nav-link p-0',
        7 => 'landing-block-node-menu-list-item-link nav-link p-0',
      ),
      '.navbar' => 
      array (
        0 => 'navbar navbar-expand-lg g-py-0 g-mt-3 u-navbar-color-white',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block landing-block-menu u-header u-header--floating u-header--floating-relative g-z-index-9999 g-bg-black-opacity-0_9',
      ),
    ),
    'attrs' => 
    array (
      '.navbar-collapse' => 
      array (
        0 => 
        array (
          'id' => 'navBar908',
        ),
      ),
      'button.navbar-toggler' => 
      array (
        0 => 
        array (
          'aria-controls' => 'navBar908',
          'data-target' => '#navBar908',
        ),
      ),
    ),
  ),
  '#block910' => 
  array (
    'old_id' => 910,
    'code' => '01.big_with_text_3',
    'nodes' => 
    array (
      '.landing-block-node-img' => 
      array (
        0 => 
        array (
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/74539b7df027f3a751d5962c6496fa41.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'Магазин Электроники и аксессуаров',
      ),
      '.landing-block-node-text' => 
      array (
        0 => 'Телефоны, фото и видеокамеры, гаджеты и аксессуары от производителя по умеренным ценам.',
      ),
      '.landing-block-node-button' => 
      array (
        0 => 
        array (
          'href' => '#block918',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Перейти в каталог',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-container' => 
      array (
        0 => 'landing-block-node-container container g-max-width-800 js-animation fadeInDown text-center u-bg-overlay__inner g-mx-1',
      ),
      '.landing-block-node-button-container' => 
      array (
        0 => 'landing-block-node-button-container',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'landing-block-node-title text-uppercase g-font-weight-700 g-color-white g-mb-20 text-center g-font-size-55 g-line-height-1_2 g-letter-spacing-0',
      ),
      '.landing-block-node-text' => 
      array (
        0 => 'landing-block-node-text g-color-white-opacity-0_7 g-mb-35 text-center',
      ),
      '.landing-block-node-button' => 
      array (
        0 => 'landing-block-node-button btn btn-xl u-btn-primary text-uppercase g-font-weight-700 g-font-size-12 g-py-15 g-px-40 g-rounded-3',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block landing-block-node-img u-bg-overlay g-flex-centered g-height-100vh g-bg-img-hero g-bg-black-opacity-0_5--after g-pt-80 g-pb-80 g-pl-0 g-pr-0 g-mt-0',
      ),
    ),
  ),
  '#block911' => 
  array (
    'old_id' => 911,
    'code' => '34.4.two_cols_with_text_and_icons',
    'cards' => 
    array (
      '.landing-block-node-card' => 3,
    ),
    'nodes' => 
    array (
      '.landing-block-node-card-icon' => 
      array (
        0 => 
        array (
          'classList' => 
          array (
            0 => 'landing-block-node-card-icon icon-rocket',
          ),
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        1 => 
        array (
          'classList' => 
          array (
            0 => 'landing-block-node-card-icon icon-like',
          ),
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        2 => 
        array (
          'classList' => 
          array (
            0 => 'landing-block-node-card-icon icon-cursor',
          ),
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-card-title' => 
      array (
        0 => 'Товары от производителя',
        1 => 'Контроль качества товаров',
        2 => 'Работаем в россии и странах снг',
      ),
      '.landing-block-node-card-text' => 
      array (
        0 => '
С гарантией качества и доп. условиями на использование.

',
        1 => '
Все товары в магазине были проверены нашими специалистами.

',
        2 => '
Доступна доставка в регионы зарубежья.

',
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-card' => 
      array (
        0 => 'landing-block-node-card js-animation fadeInUp col-md-6 g-mb-40 landing-card col-lg-4',
        1 => 'landing-block-node-card js-animation fadeInUp col-md-6 g-mb-40 landing-card col-lg-4',
        2 => 'landing-block-node-card js-animation fadeInUp col-md-6 g-mb-40 landing-card col-lg-4',
      ),
      '.landing-block-node-card-text' => 
      array (
        0 => 'landing-block-node-card-text g-font-size-default g-color-gray-dark-v2 mb-0',
        1 => 'landing-block-node-card-text g-font-size-default g-color-gray-dark-v2 mb-0',
        2 => 'landing-block-node-card-text g-font-size-default g-color-gray-dark-v2 mb-0',
      ),
      '.landing-block-node-card-title' => 
      array (
        0 => 'landing-block-node-card-title h5 text-uppercase g-font-weight-800',
        1 => 'landing-block-node-card-title h5 text-uppercase g-font-weight-800',
        2 => 'landing-block-node-card-title h5 text-uppercase g-font-weight-800',
      ),
      '.landing-block-node-card-icon-container' => 
      array (
        0 => 'landing-block-node-card-icon-container g-color-primary d-block g-font-size-48 g-line-height-1',
        1 => 'landing-block-node-card-icon-container g-color-primary d-block g-font-size-48 g-line-height-1',
        2 => 'landing-block-node-card-icon-container g-color-primary d-block g-font-size-48 g-line-height-1',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block g-pb-0 g-pt-55',
      ),
    ),
  ),
  '#block912' => 
  array (
    'old_id' => 912,
    'code' => '43.2.three_tiles_with_img_zoom',
    'nodes' => 
    array (
      '.landing-block-node-subtitle1' => 
      array (
        0 => 'Телефоны iTruba',
      ),
      '.landing-block-node-title1' => 
      array (
        0 => '40%
Скидка',
      ),
      '.landing-block-node-button1' => 
      array (
        0 => 
        array (
          'href' => '#',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Подробнее',
        ),
      ),
      '.landing-block-node-img1' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/ff0071bc7f42783e52daf25f44901906.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-subtitle2' => 
      array (
        0 => '20% Скидка',
      ),
      '.landing-block-node-title2' => 
      array (
        0 => 'Гаджеты',
      ),
      '.landing-block-node-text2' => 
      array (
        0 => 'и аксессуары',
      ),
      '.landing-block-node-img2' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/20ead570e5aebe166e183aea07f36b61.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-title-mini' => 
      array (
        0 => 'Акции',
        1 => 'Фото и видео',
      ),
      '.landing-block-node-text-mini' => 
      array (
        0 => '
Всегда новые интересные предложения

',
        1 => '
Новые поступления

',
      ),
      '.landing-block-node-img-mini' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/43cd0fd517b84fc36f7b1e0eb8482a45.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-block' => 
      array (
        0 => 'landing-block-node-block js-animation fadeInUp text-center u-block-hover u-bg-overlay g-color-white g-bg-img-hero g-bg-black-opacity-0_3--after',
        1 => 'landing-block-node-block js-animation fadeInUp text-center u-block-hover u-bg-overlay g-color-white g-bg-img-hero g-bg-black-opacity-0_3--after',
        2 => 'landing-block-node-block js-animation fadeInUp text-center u-block-hover u-bg-overlay g-color-white g-bg-img-hero g-bg-black-opacity-0_3--after',
      ),
      '.landing-block-node-subtitle1' => 
      array (
        0 => 'landing-block-node-subtitle1 g-font-weight-700 g-font-size-18 g-color-white g-brd-bottom g-brd-2 g-brd-primary g-mb-20',
      ),
      '.landing-block-node-title1' => 
      array (
        0 => 'landing-block-node-title1 text-uppercase g-line-height-1 g-font-weight-700 g-font-size-40 g-mb-30',
      ),
      '.landing-block-node-subtitle2' => 
      array (
        0 => 'landing-block-node-subtitle2 g-font-weight-700 g-font-size-16 g-mb-5 g-color-white',
      ),
      '.landing-block-node-title2' => 
      array (
        0 => 'landing-block-node-title2 text-uppercase g-line-height-1 g-font-weight-700 g-font-size-28 g-mb-10',
      ),
      '.landing-block-node-button1' => 
      array (
        0 => 'landing-block-node-button1 btn btn-md text-uppercase u-btn-primary g-font-weight-700 g-font-size-11 g-brd-none rounded-0 g-py-10 g-px-25',
      ),
      '.landing-block-node-text2' => 
      array (
        0 => 'landing-block-node-text2 g-font-weight-700 g-font-size-16 g-color-white mb-0',
      ),
      '.landing-block-node-title-mini' => 
      array (
        0 => 'landing-block-node-title-mini text-uppercase g-font-weight-700 g-font-size-18 g-color-white g-mb-10',
        1 => 'landing-block-node-title-mini text-uppercase g-font-weight-700 g-font-size-18 g-color-white g-mb-5',
      ),
      '.landing-block-node-text-mini' => 
      array (
        0 => 'landing-block-node-text-mini g-font-size-12 g-color-white mb-0',
        1 => 'landing-block-node-text-mini g-font-size-12 g-color-white mb-0',
      ),
      '.landing-block-node-img-mini' => 
      array (
        0 => 'landing-block-node-img-mini w-100 u-block-hover__main--zoom-v1',
      ),
      '.landing-block-node-bg-mini' => 
      array (
        0 => 'landing-block-node-bg-mini js-animation fadeInUp text-center u-block-hover g-color-white g-bg-primary g-mb-30',
      ),
      '.landing-block-node-button1-container' => 
      array (
        0 => 'landing-block-node-button1-container',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block g-pb-80 g-pt-20',
      ),
    ),
  ),
  '#block913' => 
  array (
    'old_id' => 913,
    'code' => '40.4.slider_blocks_with_img_and_text',
    'cards' => 
    array (
      '.landing-block-node-card' => 2,
    ),
    'nodes' => 
    array (
      '.landing-block-node-subtitle' => 
      array (
        0 => ' ',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'новые поступления —
				смартфоны',
      ),
      '.landing-block-node-text' => 
      array (
        0 => '
Каталог телефонов пополнился новыми смартфонами и гаджетами к ним.

',
      ),
      '.landing-block-node-card-img' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/f34c2535235e2153b75332f385ad757a.png',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        1 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/mockups/mockup5.png',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-card-img2' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/976c6fc2a6c57f6a4cd068935a53d75c.png',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        1 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/mockups/mockup6.png',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-card-title' => 
      array (
        0 => 'Гаджеты и аксессуары',
        1 => 'Новая линейка iTruba',
      ),
      '.landing-block-node-card-text' => 
      array (
        0 => '
Уже доступно в нашем каталоге.

',
        1 => '
Уже доступно в нашем каталоге.

',
      ),
      '.landing-block-node-card-button' => 
      array (
        0 => 
        array (
          'href' => '#block918',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'В каталог',
        ),
        1 => 
        array (
          'href' => '#block918',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'В каталог',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-subtitle' => 
      array (
        0 => 'landing-block-node-subtitle g-font-weight-700 g-color-white g-mb-15 g-font-size-11',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'landing-block-node-title js-animation fadeInLeft g-line-height-1_3 g-font-size-36 mb-0 g-color-black-opacity-0_9',
      ),
      '.landing-block-node-text' => 
      array (
        0 => 'landing-block-node-text js-animation fadeInLeft mb-0 g-color-black-opacity-0_6',
      ),
      '.landing-block-node-card-title' => 
      array (
        0 => 'landing-block-node-card-title h6 text-uppercase g-font-weight-700 g-mb-15 g-color-black-opacity-0_9',
        1 => 'landing-block-node-card-title h6 text-uppercase g-font-weight-700 g-mb-15 g-color-black-opacity-0_9',
      ),
      '.landing-block-node-card-text' => 
      array (
        0 => 'landing-block-node-card-text js-animation fadeInLeft g-font-size-default g-mb-30 g-color-black-opacity-0_7',
        1 => 'landing-block-node-card-text js-animation fadeInLeft g-font-size-default g-mb-30 g-color-black-opacity-0_7',
      ),
      '.landing-block-node-card-button' => 
      array (
        0 => 'landing-block-node-card-button js-animation fadeInLeft btn btn-lg text-uppercase u-btn-white g-font-weight-700 g-font-size-12 g-rounded-10 g-px-25 g-py-12 mb-0',
        1 => 'landing-block-node-card-button js-animation fadeInLeft btn btn-lg text-uppercase u-btn-white g-font-weight-700 g-font-size-12 g-rounded-10 g-px-25 g-py-12 mb-0',
      ),
      '.landing-block-node-card-button-container' => 
      array (
        0 => 'landing-block-node-card-button-container',
        1 => 'landing-block-node-card-button-container',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block g-pt-40 g-pb-40 g-bg-gray-light-v4',
      ),
    ),
  ),
  '#block914' => 
  array (
    'old_id' => 914,
    'code' => '19.5.cover_with_img_text_and_buttons',
    'cards' => 
    array (
      '.landing-block-node-card' => 1,
    ),
    'nodes' => 
    array (
      '.landing-block-node-title' => 
      array (
        0 => 'Успей купить
Leica D-LUX 6',
      ),
      '.landing-block-node-text' => 
      array (
        0 => 'Используя доступный по цене (но без ущерба для производительности), стильный и надежный.
Компактная фотокамера
, матрица 12.7 МП (1/1.7"), съемка_видео Full HD, оптический зум 3.80x 

',
      ),
      '.landing-block-node-img' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/212158826ae1ee1b79989e92abc60b11.png',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-card-button-img' => 
      array (
        0 => 
        array (
          'alt' => 'Каталог',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/0d7d8a42ca352937e38d67e953021ff3.png',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-card-button' => 
      array (
        0 => 
        array (
          'href' => '#block918',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '
									Каталог
								',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-title' => 
      array (
        0 => 'landing-block-node-title text-uppercase g-line-height-1_3 g-font-size-36 g-mb-20 g-mb-30--lg g-color-white',
      ),
      '.landing-block-node-text' => 
      array (
        0 => 'landing-block-node-text g-color-white-opacity-0_9',
      ),
      '.landing-block-node-img' => 
      array (
        0 => 'landing-block-node-img js-animation slideInUp img-fluid',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block g-bg-primary-dark-v1 g-pt-90 g-pb-90',
      ),
    ),
  ),
  '#block916' => 
  array (
    'old_id' => 916,
    'code' => '04.2.one_col_fix_with_title_2',
    'nodes' => 
    array (
      '.landing-block-node-subtitle' => 
      array (
        0 => ' ',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'Каталог товаров',
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-subtitle' => 
      array (
        0 => 'landing-block-node-subtitle h6 g-font-weight-800 g-font-size-12 g-letter-spacing-1 g-color-primary g-mb-20',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'landing-block-node-title h1 u-heading-v2__title g-line-height-1_3 g-font-weight-600 g-mb-minus-10 g-color-black-opacity-0_9 g-font-size-30',
      ),
      '.landing-block-node-inner' => 
      array (
        0 => 'landing-block-node-inner text-uppercase text-center u-heading-v2-4--bottom g-brd-primary',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block js-animation slideInLeft g-bg-white g-pt-40 g-pb-0',
      ),
    ),
  ),
  '#block917' => 
  array (
    'old_id' => 917,
    'code' => 'bxready.filter.preset',
    'nodes' => 
    array (
      'bxready24:filter.preset' => 
      array (
        'FILTER_PRESET_ID' => '8',
      ),
    ),
  ),
  '#block918' => 
  array (
    'old_id' => 918,
    'code' => 'bxready.store.catalog.list',
    'nodes' => 
    array (
      'bitrix:sale.basket.basket.line' => 
      array (
        'PRODUCT_ROW_VARIANTS' => 
        array (
          0 => 3,
          1 => 4,
          2 => 3,
        ),
        'BXREADY24_LIST_MARKER_TYPE' => 'circle-vertical-small',
        'DISCOUNT_PERCENT_POSITION' => 'bottom-right',
        'PRODUCT_BLOCKS_ORDER' => 
        array (
          0 => 'props',
          1 => 'sku',
          2 => 'price',
          3 => 'quantity',
          4 => 'buttons',
          5 => 'quantityLimit',
          6 => 'compare',
        ),
      ),
      'bitrix:catalog.section' => 
      array (
        'PAGE_ELEMENT_COUNT' => '12',
        'ELEMENT_SORT_FIELD' => 'sort',
        'ELEMENT_SORT_ORDER' => 'desc',
        'MESS_BTN_BUY' => '',
        'MESS_BTN_ADD_TO_BASKET' => '',
        'MESS_BTN_SUBSCRIBE' => '',
        'MESS_BTN_DETAIL' => '',
        'MESS_NOT_AVAILABLE' => '',
        'PRODUCT_ROW_VARIANTS' => 
        array (
          0 => 3,
          1 => 4,
          2 => 3,
        ),
        'BXREADY24_LIST_MARKER_TYPE' => 'circle-vertical-small',
        'DISCOUNT_PERCENT_POSITION' => 'bottom-right',
        'PRODUCT_BLOCKS_ORDER' => 
        array (
          0 => 'props',
          1 => 'sku',
          2 => 'price',
          3 => 'quantity',
          4 => 'buttons',
          5 => 'quantityLimit',
          6 => 'compare',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-component' => 
      array (
        0 => 'landing-component',
      ),
      '#wrapper' => 
      array (
        0 => 'g-bg-transparent',
      ),
    ),
  ),
  '#block919' => 
  array (
    'old_id' => 919,
    'code' => '04.2.one_col_fix_with_title_2',
    'nodes' => 
    array (
      '.landing-block-node-subtitle' => 
      array (
        0 => ' ',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'Фото, видео и гаджеты',
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-subtitle' => 
      array (
        0 => 'landing-block-node-subtitle h6 g-font-weight-800 g-font-size-12 g-letter-spacing-1 g-color-primary g-mb-20',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'landing-block-node-title h1 u-heading-v2__title g-line-height-1_3 g-font-weight-600 g-mb-minus-10 g-color-black-opacity-0_9 g-font-size-30',
      ),
      '.landing-block-node-inner' => 
      array (
        0 => 'landing-block-node-inner text-uppercase text-center u-heading-v2-4--bottom g-brd-primary',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block js-animation slideInLeft g-bg-gray-light-v5 g-pb-0 g-mt-40 g-pt-50',
      ),
    ),
  ),
  '#block920' => 
  array (
    'old_id' => 920,
    'code' => 'bxready.filter.preset',
    'nodes' => 
    array (
      'bxready24:filter.preset' => 
      array (
        'FILTER_PRESET_ID' => '9',
      ),
    ),
  ),
  '#block921' => 
  array (
    'old_id' => 921,
    'code' => 'bxready.store.catalog.list',
    'nodes' => 
    array (
      'bitrix:sale.basket.basket.line' => 
      array (
        'PRODUCT_ROW_VARIANTS' => 
        array (
          0 => 6,
          1 => 9,
          2 => 9,
          3 => 9,
        ),
        'BXREADY24_LIST_MARKER_TYPE' => 'ribbon-vertical',
        'DISCOUNT_PERCENT_POSITION' => 'bottom-right',
        'PRODUCT_BLOCKS_ORDER' => 
        array (
          0 => 'props',
          1 => 'sku',
          2 => 'price',
          3 => 'quantity',
          4 => 'buttons',
          5 => 'quantityLimit',
          6 => 'compare',
        ),
      ),
      'bitrix:catalog.section' => 
      array (
        'PAGE_ELEMENT_COUNT' => '12',
        'ELEMENT_SORT_FIELD' => 'sort',
        'ELEMENT_SORT_ORDER' => 'desc',
        'MESS_BTN_BUY' => '',
        'MESS_BTN_ADD_TO_BASKET' => '',
        'MESS_BTN_SUBSCRIBE' => '',
        'MESS_BTN_DETAIL' => '',
        'MESS_NOT_AVAILABLE' => '',
        'PRODUCT_ROW_VARIANTS' => 
        array (
          0 => 6,
          1 => 9,
          2 => 9,
          3 => 9,
        ),
        'BXREADY24_LIST_MARKER_TYPE' => 'ribbon-vertical',
        'DISCOUNT_PERCENT_POSITION' => 'bottom-right',
        'PRODUCT_BLOCKS_ORDER' => 
        array (
          0 => 'props',
          1 => 'sku',
          2 => 'price',
          3 => 'quantity',
          4 => 'buttons',
          5 => 'quantityLimit',
          6 => 'compare',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-component' => 
      array (
        0 => 'landing-component',
      ),
      '#wrapper' => 
      array (
        0 => 'g-bg-gray-light-v5 g-pt-0 g-pb-60',
      ),
    ),
  ),
  '#block922' => 
  array (
    'old_id' => 922,
    'code' => '19.2.features_with_img',
    'cards' => 
    array (
      '.landing-block-node-card' => 2,
    ),
    'nodes' => 
    array (
      '.landing-block-node-img' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/ddf68c365021e9d7269bbe68c21c408d.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-subtitle' => 
      array (
        0 => 'информация',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'Фабрика элементов BXReady24',
      ),
      '.landing-block-node-text' => 
      array (
        0 => '
Это готовое решение профессионального уровня, позволяющее вам в сжатые сроки и с минимальными издержками запустить продажи товаров, а также процесс развития своего бизнеса в онлайн среде.

',
      ),
      '.landing-block-node-card-icon' => 
      array (
        0 => 
        array (
          'classList' => 
          array (
            0 => 'landing-block-node-card-icon icon-tag',
          ),
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        1 => 
        array (
          'classList' => 
          array (
            0 => 'landing-block-node-card-icon icon-note',
          ),
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-card-title' => 
      array (
        0 => 'Удобный каталог товаров',
        1 => 'Умный фильтр',
      ),
      '.landing-block-node-card-text' => 
      array (
        0 => '
Позволяет использовать несколько представлений для товаров и их вывода. Уникальный дизайн, поддержка адаптивности и технологии Bitrix.

',
        1 => '
Настройте фильтр товаров как вам необходимо. Выводите только то что действительно надо покупателю.

',
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-subtitle' => 
      array (
        0 => 'landing-block-node-subtitle g-font-weight-700 g-mb-15 g-font-size-12 g-letter-spacing-3',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'landing-block-node-title g-line-height-1_3 g-font-size-36 mb-0 g-color-black-opacity-0_9 text-uppercase',
      ),
      '.landing-block-node-text' => 
      array (
        0 => 'landing-block-node-text g-mb-65',
      ),
      '.landing-block-node-card-title' => 
      array (
        0 => 'landing-block-node-card-title h6 text-uppercase g-font-weight-700 g-color-black g-mb-15',
        1 => 'landing-block-node-card-title h6 text-uppercase g-font-weight-700 g-color-black g-mb-15',
      ),
      '.landing-block-node-card-text' => 
      array (
        0 => 'landing-block-node-card-text g-font-size-default mb-0',
        1 => 'landing-block-node-card-text g-font-size-default mb-0',
      ),
      '.landing-block-node-card-icon-border' => 
      array (
        0 => 'landing-block-node-card-icon-border u-icon-v2 u-icon-size--lg g-font-size-26 g-color-primary g-rounded-50x',
        1 => 'landing-block-node-card-icon-border u-icon-v2 u-icon-size--lg g-font-size-26 g-color-primary g-rounded-50x',
      ),
      '.landing-block-node-img' => 
      array (
        0 => 'landing-block-node-img js-animation slideInLeft img-fluid',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block g-pt-90 g-bg-white g-pb-40 g-mt-20',
      ),
    ),
  ),
  '#block923' => 
  array (
    'old_id' => 923,
    'code' => '24.3.image_gallery_6_cols_fix_3',
    'cards' => 
    array (
      '.landing-block-node-card' => 6,
    ),
    'nodes' => 
    array (
      '.landing-block-node-img' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/x74/img1.png',
        ),
        1 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/x74/img2.png',
        ),
        2 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/x74/img3.png',
        ),
        3 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/x74/img4.png',
        ),
        4 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/x74/img4.png',
        ),
        5 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/x74/img6.png',
        ),
      ),
      '.landing-block-card-logo-link' => 
      array (
        0 => 
        array (
          'href' => '#',
          'target' => NULL,
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '
					
				',
        ),
        1 => 
        array (
          'href' => '#',
          'target' => NULL,
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '
					
				',
        ),
        2 => 
        array (
          'href' => '#',
          'target' => NULL,
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '
					
				',
        ),
        3 => 
        array (
          'href' => '#',
          'target' => NULL,
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '
					
				',
        ),
        4 => 
        array (
          'href' => '#',
          'target' => NULL,
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '
					
				',
        ),
        5 => 
        array (
          'href' => '#',
          'target' => NULL,
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '
					
				',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-card' => 
      array (
        0 => 'landing-block-node-card col-md-4 col-lg-2 g-flex-centered g-brd-bottom g-brd-right g-brd-gray-light-v4 g-py-50 landing-card',
        1 => 'landing-block-node-card col-md-4 col-lg-2 g-flex-centered g-brd-bottom g-brd-right g-brd-gray-light-v4 g-py-50',
        2 => 'landing-block-node-card col-md-4 col-lg-2 g-flex-centered g-brd-bottom g-brd-right g-brd-gray-light-v4 g-py-50',
        3 => 'landing-block-node-card col-md-4 col-lg-2 g-flex-centered g-brd-bottom g-brd-right g-brd-gray-light-v4 g-py-50',
        4 => 'landing-block-node-card col-md-4 col-lg-2 g-flex-centered g-brd-bottom g-brd-right g-brd-gray-light-v4 g-py-50',
        5 => 'landing-block-node-card col-md-4 col-lg-2 g-flex-centered g-brd-bottom g-brd-right g-brd-gray-light-v4 g-py-50',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block js-animation zoomIn text-center g-pt-30 g-bg-white g-pb-50 g-mt-10',
      ),
    ),
  ),
  '#block924' => 
  array (
    'old_id' => 924,
    'code' => '27.one_col_fix_title_and_text_2',
    'nodes' => 
    array (
      '.landing-block-node-title' => 
      array (
        0 => 'Отзывы',
      ),
      '.landing-block-node-text' => 
      array (
        0 => ' ',
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-title' => 
      array (
        0 => 'landing-block-node-title g-font-weight-400 text-uppercase g-color-black',
      ),
      '.landing-block-node-text' => 
      array (
        0 => 'landing-block-node-text g-font-size-16 g-pb-1 g-color-black',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block js-animation fadeInUp g-bg-gray-light-v5 g-pb-0 g-pt-50',
      ),
    ),
  ),
  '#block925' => 
  array (
    'old_id' => 925,
    'code' => '29.three_cols_texts_blocks_slider',
    'cards' => 
    array (
      '.landing-block-card-slider-element' => 5,
    ),
    'nodes' => 
    array (
      '.landing-block-node-element-text' => 
      array (
        0 => '
Спасибо компании за помощь в настройке, запуске и доработке нашего аппарата. Хорошие и грамотные специалисты. И советом помогают если потребуется.    

',
        1 => '
Спасибо компании за помощь в настройке, запуске и доработке.     

',
        2 => 'Хорошие и грамотные специалисты и советом помогают если потребуется. Сервис отличный, успехов ребятам в их начинаниях!',
        3 => '
Спасибо компании за помощь в настройке, запуске и доработке.     

',
        4 => 'Хорошие и грамотные специалисты и советом помогают если потребуется. Сервис отличный, успехов ребятам в их начинаниях!',
      ),
      '.landing-block-node-element-img' => 
      array (
        0 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/100x100/img1.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        1 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/100x100/img5.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        2 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/100x100/img2.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        3 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bxready.ru/pictures/bxready24_template/db97eaf62f0b24bec9090b61b351d7eb.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        4 => 
        array (
          'alt' => '',
          'src' => 'https://cdn.bitrix24.site/bitrix/images/landing/business/100x100/img2.jpg',
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-element-title' => 
      array (
        0 => 'Саша Водная',
        1 => 'Валерий',
        2 => 'Волокушка',
        3 => 'Николай',
        4 => 'Игорь',
      ),
      '.landing-block-node-element-subtitle' => 
      array (
        0 => 'ООО "Я Вода"',
        1 => 'ОАО "Интертам"',
        2 => 'ООО "Гозек"',
        3 => 'ОАО "Интертам"',
        4 => 'ООО "Грамонис"',
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-element-text' => 
      array (
        0 => 'landing-block-node-element-text u-blockquote-v8 g-font-weight-300 g-font-size-15 rounded g-pa-25 g-mb-25',
        1 => 'landing-block-node-element-text u-blockquote-v8 g-font-weight-300 g-font-size-15 rounded g-pa-25 g-mb-25',
        2 => 'landing-block-node-element-text u-blockquote-v8 g-font-weight-300 g-font-size-15 rounded g-pa-25 g-mb-25',
        3 => 'landing-block-node-element-text u-blockquote-v8 g-font-weight-300 g-font-size-15 rounded g-pa-25 g-mb-25',
        4 => 'landing-block-node-element-text u-blockquote-v8 g-font-weight-300 g-font-size-15 rounded g-pa-25 g-mb-25',
      ),
      '.landing-block-node-element-title' => 
      array (
        0 => 'landing-block-node-element-title g-font-weight-400 g-font-size-15 g-color-main g-mb-0',
        1 => 'landing-block-node-element-title g-font-weight-400 g-font-size-15 g-color-main g-mb-0',
        2 => 'landing-block-node-element-title g-font-weight-400 g-font-size-15 g-color-main g-mb-0',
        3 => 'landing-block-node-element-title g-font-weight-400 g-font-size-15 g-color-main g-mb-0',
        4 => 'landing-block-node-element-title g-font-weight-400 g-font-size-15 g-color-main g-mb-0',
      ),
      '.landing-block-node-element-subtitle' => 
      array (
        0 => 'landing-block-node-element-subtitle g-color-main g-font-size-13',
        1 => 'landing-block-node-element-subtitle g-color-main g-font-size-13',
        2 => 'landing-block-node-element-subtitle g-color-main g-font-size-13',
        3 => 'landing-block-node-element-subtitle g-color-main g-font-size-13',
        4 => 'landing-block-node-element-subtitle g-color-main g-font-size-13',
      ),
      '#wrapper' => 
      array (
        0 => 'landing-block js-animation fadeIn g-bg-gray-light-v5 g-mt-0',
      ),
    ),
  ),
  '#block926' => 
  array (
    'old_id' => 926,
    'code' => '35.1.footer_light',
    'cards' => 
    array (
      '.landing-block-card-contact' => 3,
      '.landing-block-card-list1-item' => 3,
      '.landing-block-card-list2-item' => 2,
      '.landing-block-card-list3-item' => 4,
    ),
    'nodes' => 
    array (
      '.landing-block-node-title' => 
      array (
        0 => 'Контакты',
        1 => 'Каталог',
        2 => 'Инфо',
        3 => 'Клиентам',
      ),
      '.landing-block-node-text' => 
      array (
        0 => '
Интернет-магазин "Электроники"

',
      ),
      '.landing-block-node-card-contact-icon' => 
      array (
        0 => 
        array (
          'classList' => 
          array (
            0 => 'landing-block-node-card-contact-icon fa fa-home',
          ),
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        1 => 
        array (
          'classList' => 
          array (
            0 => 'landing-block-node-card-contact-icon fa fa-phone',
          ),
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
        2 => 
        array (
          'classList' => 
          array (
            0 => 'landing-block-node-card-contact-icon fa fa-envelope',
          ),
          'data-pseudo-url' => '{"text":"","href":"","target":"_self","enabled":false}',
        ),
      ),
      '.landing-block-node-card-contact-text' => 
      array (
        0 => 'Адрес: ул. Волошки д.1 оф. 548',
        1 => 'Телефон:',
        2 => 'Email:',
      ),
      '.landing-block-node-list-item' => 
      array (
        0 => 
        array (
          'href' => '#block916',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Список товаров',
        ),
        1 => 
        array (
          'href' => '#block919',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Фото и видео',
        ),
        2 => 
        array (
          'href' => '#block916',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Телефоны и аксессуары',
        ),
        3 => 
        array (
          'href' => '#block911',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Преимущества',
        ),
        4 => 
        array (
          'href' => '#block922',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'О нас',
        ),
        5 => 
        array (
          'href' => '#',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Главная',
        ),
        6 => 
        array (
          'href' => '#block912',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Акции',
        ),
        7 => 
        array (
          'href' => '#block913',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Промо',
        ),
        8 => 
        array (
          'href' => '#block914',
          'target' => '_self',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'Успей купить',
        ),
      ),
      '.landing-block-node-card-contact-link' => 
      array (
        0 => 
        array (
          'href' => 'tel:+7 (000) 000-00-00',
          'target' => '_blank',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => '+7 (000) 000-00-00',
        ),
        1 => 
        array (
          'href' => 'mailto:support@nonames.com',
          'target' => '_blank',
          'attrs' => 
          array (
            'data-embed' => NULL,
            'data-url' => NULL,
          ),
          'text' => 'support@nonames.com',
        ),
      ),
    ),
    'style' => 
    array (
      '.landing-block-node-card' => 
      array (
        0 => 'landing-block-node-card js-animation fadeInRight col-sm-12 col-md-2 col-lg-2 g-mb-25 g-mb-0--lg',
        1 => 'landing-block-node-card js-animation bounceInRight col-sm-12 col-md-2 col-lg-2 g-mb-25 g-mb-0--lg',
        2 => 'landing-block-node-card js-animation bounceInRight col-sm-12 col-md-2 col-lg-2 g-mb-25 g-mb-0--lg',
      ),
      '.landing-block-node-card-contact-icon-container' => 
      array (
        0 => 'landing-block-node-card-contact-icon-container g-absolute-centered--y g-left-0 g-color-white-opacity-0_5',
        1 => 'landing-block-node-card-contact-icon-container g-absolute-centered--y g-left-0 g-color-white-opacity-0_5',
        2 => 'landing-block-node-card-contact-icon-container g-absolute-centered--y g-left-0 g-color-white-opacity-0_5',
      ),
      '.landing-block-node-main-card' => 
      array (
        0 => 'landing-block-node-main-card js-animation fadeInLeft col-sm-12 col-md-6 col-lg-6 g-mb-25 g-mb-0--lg',
      ),
      '.landing-block-node-title' => 
      array (
        0 => 'landing-block-node-title text-uppercase g-font-weight-700 g-font-size-16 g-mb-20 g-color-white',
        1 => 'landing-block-node-title text-uppercase g-font-weight-700 g-font-size-16 g-mb-20 g-color-white',
        2 => 'landing-block-node-title text-uppercase g-font-weight-700 g-font-size-16 g-mb-20 g-color-white',
        3 => 'landing-block-node-title text-uppercase g-font-weight-700 g-font-size-16 g-mb-20 g-color-white',
      ),
      '.landing-block-node-text' => 
      array (
        0 => 'landing-block-node-text g-font-size-default g-mb-20 g-color-white-opacity-0_6',
      ),
      '.landing-block-node-card-contact-text' => 
      array (
        0 => 'landing-block-node-card-contact-text g-color-white-opacity-0_5',
        1 => 'landing-block-node-card-contact-text g-color-white-opacity-0_5',
        2 => 'landing-block-node-card-contact-text',
      ),
      '.landing-block-node-list-item' => 
      array (
        0 => 'landing-block-node-list-item g-color-gray-dark-v5',
        1 => 'landing-block-node-list-item g-color-gray-dark-v5',
        2 => 'landing-block-node-list-item g-color-gray-dark-v5',
        3 => 'landing-block-node-list-item g-color-gray-dark-v5',
        4 => 'landing-block-node-list-item g-color-gray-dark-v5',
        5 => 'landing-block-node-list-item g-color-gray-dark-v5',
        6 => 'landing-block-node-list-item g-color-gray-dark-v5',
        7 => 'landing-block-node-list-item g-color-gray-dark-v5',
        8 => 'landing-block-node-list-item g-color-gray-dark-v5',
      ),
      '.landing-block-node-card-contact-link' => 
      array (
        0 => 'landing-block-node-card-contact-link g-font-weight-700 g-color-white-opacity-0_5',
        1 => 'landing-block-node-card-contact-link g-font-weight-700 g-color-white-opacity-0_5',
      ),
      '#wrapper' => 
      array (
        0 => 'g-pt-60 g-pb-60 g-bg-black-opacity-0_9',
      ),
    ),
  ),
),
);
