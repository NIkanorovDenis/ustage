<?php
$arUrlRewrite=array (
  67 => 
  array (
    'CONDITION' => '#^/landing/pub/calendar-event/([0-9]+)/([0-9a-zA-Z]+)/?([^/]*)#',
    'RULE' => 'event_id=$1&hash=$2',
    'ID' => 'bitrix:calendar.pub.event',
    'PATH' => '/landing/pub/calendar_event.php',
    'SORT' => 100,
  ),
  54 => 
  array (
    'CONDITION' => '#^/docs/pub/(?<hash>[0-9a-f]{32})/(?<action>[0-9a-zA-Z]+)/\\?#',
    'RULE' => 'hash=$1&action=$2&',
    'ID' => 'bitrix:disk.external.link',
    'PATH' => '/docs/pub/index.php',
    'SORT' => 100,
  ),
  85 => 
  array (
    'CONDITION' => '#^/landing/pub/calendar-sharing/([0-9a-zA-Z]+)/?([^/]*)#',
    'RULE' => 'hash=$1',
    'ID' => 'bitrix:calendar.pub.sharing',
    'PATH' => '/landing/pub/calendar_sharing.php',
    'SORT' => 100,
  ),
  66 => 
  array (
    'CONDITION' => '#^/pub/calendar-event/([0-9]+)/([0-9a-zA-Z]+)/?([^/]*)#',
    'RULE' => 'event_id=$1&hash=$2',
    'ID' => 'bitrix:calendar.pub.event',
    'PATH' => '/pub/calendar_event.php',
    'SORT' => 100,
  ),
  55 => 
  array (
    'CONDITION' => '#^/disk/(?<action>[0-9a-zA-Z]+)/(?<fileId>[0-9]+)/\\?#',
    'RULE' => 'action=$1&fileId=$2&',
    'ID' => 'bitrix:disk.services',
    'PATH' => '/bitrix/services/disk/index.php',
    'SORT' => 100,
  ),
  84 => 
  array (
    'CONDITION' => '#^/pub/calendar-sharing/([0-9a-zA-Z]+)/?([^/]*)#',
    'RULE' => 'hash=$1',
    'ID' => 'bitrix:calendar.pub.sharing',
    'PATH' => '/pub/calendar_sharing.php',
    'SORT' => 100,
  ),
  61 => 
  array (
    'CONDITION' => '#^\\/?\\/mobile/web_mobile_component\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobile/webcomponent.php',
    'SORT' => 100,
  ),
  111 => 
  array (
    'CONDITION' => '#^/disk/boards/([0-9]+)/openAttachedDocument#',
    'RULE' => 'action=disk.integration.flipchart.openAttachedDocument&attachedObjectId=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/main/ajax.php',
    'SORT' => 100,
  ),
  41 => 
  array (
    'CONDITION' => '#^/pub/pay/([\\w\\W]+)/([0-9a-zA-Z]+)/([^/]*)#',
    'RULE' => 'account_number=$1&hash=$2',
    'ID' => NULL,
    'PATH' => '/pub/payment.php',
    'SORT' => 100,
  ),
  104 => 
  array (
    'CONDITION' => '#^/pub/booking/confirmation/([0-9a-z\\.]+)/#',
    'RULE' => 'hash=$1',
    'ID' => 'bitrix:booking.pub.confirm',
    'PATH' => '/pub/booking/confirmation.php',
    'SORT' => 100,
  ),
  74 => 
  array (
    'CONDITION' => '#^/bitrix/services/yandexpay.pay/trading/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/yandexpay.pay/trading/index.php',
    'SORT' => 100,
  ),
  58 => 
  array (
    'CONDITION' => '#^\\/?\\/mobile/mobile_component\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobile/jscomponent.php',
    'SORT' => 100,
  ),
  62 => 
  array (
    'CONDITION' => '#^/mobile/disk/(?<hash>[0-9]+)/download#',
    'RULE' => 'download=1&objectId=$1',
    'ID' => 'bitrix:mobile.disk.file.detail',
    'PATH' => '/mobile/disk/index.php',
    'SORT' => 100,
  ),
  22 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  91 => 
  array (
    'CONDITION' => '#^/landing/pub/payment-slip/([\\w\\W]+)/#',
    'RULE' => 'signed_payment_id=$1',
    'ID' => 'bitrix:salescenter.pub.payment.slip',
    'PATH' => '/landing/pub/payment_slip.php',
    'SORT' => 100,
  ),
  51 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  82 => 
  array (
    'CONDITION' => '#^/timeman/login-history/([0-9]+)/.*#',
    'RULE' => 'user=$1',
    'ID' => 'bitrix:intranet.user.login.history',
    'PATH' => '/timeman/login-history/index.php',
    'SORT' => 100,
  ),
  112 => 
  array (
    'CONDITION' => '#^/disk/boards/([0-9]+)/openDocument#',
    'RULE' => 'action=disk.integration.flipchart.openDocument&fileId=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/main/ajax.php',
    'SORT' => 100,
  ),
  113 => 
  array (
    'CONDITION' => '#^/disk/boards/([0-9]+)/openAttached#',
    'RULE' => 'action=disk.integration.flipchart.openAttachedDocument&attachedObjectId=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/main/ajax.php',
    'SORT' => 100,
  ),
  106 => 
  array (
    'CONDITION' => '#^/bi/dashboard/detail/([0-9]+)/#',
    'RULE' => 'dashboardId=$1',
    'ID' => 'bitrix:biconnector.apachesuperset.dashboard.detail',
    'PATH' => '/bi/dashboard/detail/index.php',
    'SORT' => 100,
  ),
  60 => 
  array (
    'CONDITION' => '#^\\/?\\/mobile/jn/(.*)\\/(.*)\\/.*#',
    'RULE' => 'componentName=$2&namespace=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobile/jscomponent.php',
    'SORT' => 100,
  ),
  90 => 
  array (
    'CONDITION' => '#^/pub/payment-slip/([\\w\\W]+)/#',
    'RULE' => 'signed_payment_id=$1',
    'ID' => 'bitrix:salescenter.pub.payment.slip',
    'PATH' => '/pub/payment_slip.php',
    'SORT' => 100,
  ),
  96 => 
  array (
    'CONDITION' => '#^/sign/link/member/([0-9]+)/#',
    'RULE' => 'memberId=$1',
    'ID' => '',
    'PATH' => '/sign/link.php',
    'SORT' => 100,
  ),
  116 => 
  array (
    'CONDITION' => '#^/shop/settings/permissions/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store.entity.controller',
    'PATH' => '/shop/settings/permissions/index.php',
    'SORT' => 100,
  ),
  50 => 
  array (
    'CONDITION' => '#^/landing/marketing/toloka/#',
    'RULE' => '',
    'ID' => 'bitrix:sender.yandex.toloka',
    'PATH' => '/landing/marketing/toloka.php',
    'SORT' => 100,
  ),
  114 => 
  array (
    'CONDITION' => '#^/disk/boards/([0-9]+)/open#',
    'RULE' => 'action=disk.integration.flipchart.openDocument&fileId=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/main/ajax.php',
    'SORT' => 100,
  ),
  115 => 
  array (
    'CONDITION' => '#^/vote-result/([0-9a-z\\.]+)#',
    'RULE' => 'signedAttachId=$1',
    'ID' => NULL,
    'PATH' => '/vote-result/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  83 => 
  array (
    'CONDITION' => '#^/marketing/master-yandex/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/marketing/master-yandex.php',
    'SORT' => 100,
  ),
  59 => 
  array (
    'CONDITION' => '#^\\/?\\/mobile/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobile/jscomponent.php',
    'SORT' => 100,
  ),
  73 => 
  array (
    'CONDITION' => '#^/shop/documents-catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.catalog.controller',
    'PATH' => '/shop/documents-catalog/index.php',
    'SORT' => 100,
  ),
  103 => 
  array (
    'CONDITION' => '#^/booking/detail/([0-9]+)#',
    'RULE' => 'id=$1',
    'ID' => 'bitrix:booking.booking.detail',
    'PATH' => '/booking/detail.php',
    'SORT' => 100,
  ),
  81 => 
  array (
    'CONDITION' => '#^/shop/documents-stores/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store.entity.controller',
    'PATH' => '/shop/documents-stores/index.php',
    'SORT' => 100,
  ),
  39 => 
  array (
    'CONDITION' => '#^/stssync/contacts_crm/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/contacts_crm/index.php',
    'SORT' => 100,
  ),
  48 => 
  array (
    'CONDITION' => '#^/landing/shop/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.productcard.controller',
    'PATH' => '/landing/shop/catalog/index.php',
    'SORT' => 100,
  ),
  49 => 
  array (
    'CONDITION' => '#^/landing/crm/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.catalog.controller',
    'PATH' => '/landing/crm/catalog/index.php',
    'SORT' => 100,
  ),
  117 => 
  array (
    'CONDITION' => '#^/bi/unused_elements/#',
    'RULE' => '',
    'ID' => 'bitrix:biconnector.apachesuperset.workspace_analytic.controller',
    'PATH' => '/bi/unused_elements/index.php',
    'SORT' => 100,
  ),
  23 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  47 => 
  array (
    'CONDITION' => '#^/marketing/toloka/#',
    'RULE' => '',
    'ID' => 'bitrix:sender.yandex.toloka',
    'PATH' => '/marketing/toloka.php',
    'SORT' => 100,
  ),
  52 => 
  array (
    'CONDITION' => '#^/stssync/contacts/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/contacts/index.php',
    'SORT' => 100,
  ),
  43 => 
  array (
    'CONDITION' => '#^/shop/buyer_group/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.order.buyer_group',
    'PATH' => '/shop/buyer_group/index.php',
    'SORT' => 100,
  ),
  97 => 
  array (
    'CONDITION' => '#^/automation/type/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.router',
    'PATH' => '/automation/type/index.php',
    'SORT' => 100,
  ),
  71 => 
  array (
    'CONDITION' => '#^/calendar/rooms/#',
    'RULE' => '',
    'ID' => 'bitrix:calender',
    'PATH' => '/calendar/rooms.php',
    'SORT' => 100,
  ),
  68 => 
  array (
    'CONDITION' => '#^/company/oktava/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/company/oktava/index.php',
    'SORT' => 100,
  ),
  72 => 
  array (
    'CONDITION' => '#^/shop/documents/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store.document',
    'PATH' => '/shop/documents/index.php',
    'SORT' => 100,
  ),
  92 => 
  array (
    'CONDITION' => '#^/agent_contract/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.agent.contract.controller',
    'PATH' => '/agent_contract/index.php',
    'SORT' => 100,
  ),
  42 => 
  array (
    'CONDITION' => '#^/crm/invoicing/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/crm/invoicing/index.php',
    'SORT' => 100,
  ),
  53 => 
  array (
    'CONDITION' => '#^/stssync/tasks/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/tasks/index.php',
    'SORT' => 100,
  ),
  40 => 
  array (
    'CONDITION' => '#^/pub/site/(.*?)#',
    'RULE' => 'path=$1',
    'ID' => 'bitrix:landing.pub',
    'PATH' => '/pub/site/index.php',
    'SORT' => 100,
  ),
  88 => 
  array (
    'CONDITION' => '#^/shop/terminal/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.terminal.payment.controller',
    'PATH' => '/terminal/index.php',
    'SORT' => 100,
  ),
  98 => 
  array (
    'CONDITION' => '#^/calendar/open/#',
    'RULE' => '',
    'ID' => 'bitrix:calendar.open-events',
    'PATH' => '/calendar/open_events.php',
    'SORT' => 100,
  ),
  109 => 
  array (
    'CONDITION' => '#^/bi/statistics/#',
    'RULE' => '',
    'ID' => 'bitrix:biconnector.apachesuperset.workspace_analytic.controller',
    'PATH' => '/bi/statistics/index.php',
    'SORT' => 100,
  ),
  45 => 
  array (
    'CONDITION' => '#^/shop/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.productcard.controller',
    'PATH' => '/shop/catalog/index.php',
    'SORT' => 100,
  ),
  89 => 
  array (
    'CONDITION' => '#^/crm/terminal/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.terminal.payment.controller',
    'PATH' => '/terminal/index.php',
    'SORT' => 100,
  ),
  57 => 
  array (
    'CONDITION' => '#^/mobile/webdav#',
    'RULE' => '',
    'ID' => 'bitrix:mobile.webdav.file.list',
    'PATH' => '/mobile/webdav/index.php',
    'SORT' => 100,
  ),
  95 => 
  array (
    'CONDITION' => '#^/bi/dashboard/#',
    'RULE' => '',
    'ID' => 'bitrix:biconnector.apachesuperset.dashboard.controller',
    'PATH' => '/bi/dashboard/index.php',
    'SORT' => 100,
  ),
  46 => 
  array (
    'CONDITION' => '#^/crm/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.catalog.controller',
    'PATH' => '/crm/catalog/index.php',
    'SORT' => 100,
  ),
  56 => 
  array (
    'CONDITION' => '#^/\\.well-known#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/groupdav.php',
    'SORT' => 100,
  ),
  99 => 
  array (
    'CONDITION' => '#^/desktop/menu#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/desktop_menu/index.php',
    'SORT' => 100,
  ),
  44 => 
  array (
    'CONDITION' => '#^/shop/buyer/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.order.buyer',
    'PATH' => '/shop/buyer/index.php',
    'SORT' => 100,
  ),
  107 => 
  array (
    'CONDITION' => '#^/bi/dataset/#',
    'RULE' => '',
    'ID' => 'bitrix:biconnector.apachesuperset.workspace_analytic.controller',
    'PATH' => '/bi/dataset/index.php',
    'SORT' => 100,
  ),
  108 => 
  array (
    'CONDITION' => '#^/bi/source/#',
    'RULE' => '',
    'ID' => 'bitrix:biconnector.apachesuperset.workspace_analytic.controller',
    'PATH' => '/bi/source/index.php',
    'SORT' => 100,
  ),
  110 => 
  array (
    'CONDITION' => '#^/vibe/edit/#',
    'RULE' => '',
    'ID' => 'bitrix:landing.start',
    'PATH' => '/vibe/edit/index.php',
    'SORT' => 100,
  ),
  80 => 
  array (
    'CONDITION' => '#^/articles/#',
    'RULE' => '',
    'ID' => 'bxready.market2:block',
    'PATH' => '/articles/index.php',
    'SORT' => 100,
  ),
  32 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  87 => 
  array (
    'CONDITION' => '#^/terminal/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.terminal.payment.controller',
    'PATH' => '/terminal/index.php',
    'SORT' => 100,
  ),
  64 => 
  array (
    'CONDITION' => '#^/crm/type/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.router',
    'PATH' => '/crm/type/index.php',
    'SORT' => 100,
  ),
  119 => 
  array (
    'CONDITION' => '#^/projects/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/projects/index.php',
    'SORT' => 100,
  ),
  120 => 
  array (
    'CONDITION' => '#^/services/#',
    'RULE' => '',
    'ID' => 'bxready.market2:block',
    'PATH' => '/services/index.php',
    'SORT' => 100,
  ),
  30 => 
  array (
    'CONDITION' => '#^/landing/#',
    'RULE' => '',
    'ID' => 'concept:pages',
    'PATH' => '/landing/index.php',
    'SORT' => 100,
  ),
  78 => 
  array (
    'CONDITION' => '#^/actions/#',
    'RULE' => '',
    'ID' => 'bxready.market2:block',
    'PATH' => '/actions/index.php',
    'SORT' => 100,
  ),
  102 => 
  array (
    'CONDITION' => '#^/booking/#',
    'RULE' => '',
    'ID' => 'bitrix:booking',
    'PATH' => '/booking/index.php',
    'SORT' => 100,
  ),
  37 => 
  array (
    'CONDITION' => '#^/brands/#',
    'RULE' => '',
    'ID' => 'bxready.market2:catalog',
    'PATH' => '/brands/index.php',
    'SORT' => 100,
  ),
  86 => 
  array (
    'CONDITION' => '#^/market/#',
    'RULE' => '',
    'ID' => 'bitrix:market',
    'PATH' => '/market/index.php',
    'SORT' => 100,
  ),
  94 => 
  array (
    'CONDITION' => '#^/spaces/#',
    'RULE' => '',
    'ID' => 'bitrix:socialnetwork.spaces',
    'PATH' => '/spaces/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  65 => 
  array (
    'CONDITION' => '#^/page/#',
    'RULE' => '',
    'ID' => 'bitrix:intranet.customsection',
    'PATH' => '/page/index.php',
    'SORT' => 100,
  ),
  93 => 
  array (
    'CONDITION' => '#^/sign/#',
    'RULE' => '',
    'ID' => 'bitrix:sign.start',
    'PATH' => '/sign/index.php',
    'SORT' => 100,
  ),
  118 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bxready.market2:block',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  29 => 
  array (
    'CONDITION' => '#^/faq/#',
    'RULE' => '',
    'ID' => 'bxready2:news',
    'PATH' => '/faq/index.php',
    'SORT' => 100,
  ),
  101 => 
  array (
    'CONDITION' => '#^/crm/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.router',
    'PATH' => '/crm/index.php',
    'SORT' => 100,
  ),
  100 => 
  array (
    'CONDITION' => '#^/hr/#',
    'RULE' => '',
    'ID' => 'bitrix:humanresources.start',
    'PATH' => '/hr/index.php',
    'SORT' => 100,
  ),
  121 => 
  array (
    'CONDITION' => '#^/#',
    'RULE' => '',
    'ID' => 'bxready.market2:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
);
