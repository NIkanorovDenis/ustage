<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    return;
}

AddEventHandler('main', 'OnBuildGlobalMenu', static function (&$globalMenu, &$moduleMenu): void {
    global $USER;

    if (!$USER->IsAdmin()) {
        return;
    }

    $moduleMenu[] = [
        'parent_menu' => 'global_menu_services',
        'section' => 'ustage_cookie_consents',
        'sort' => 950,
        'text' => 'Решения по cookie',
        'title' => 'Журнал согласий и отказов от аналитических cookie',
        'url' => '/local/admin/cookie_consent_log.php?lang=' . LANGUAGE_ID,
        'more_url' => ['/local/admin/cookie_consent_log.php'],
        'items_id' => 'menu_ustage_cookie_consents',
    ];
});
