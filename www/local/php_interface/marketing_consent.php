<?php

use Bitrix\Main\Application;
use Bitrix\Main\Event;
use Bitrix\Main\EventManager;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    return;
}

final class UstageMarketingConsent
{
    private const TEXT = 'Я соглашаюсь на получение информационных и рекламных материалов, в том числе приглашений на мероприятия, и обработку моих персональных данных для этой цели';

    public static function onAfterUserRegister(array &$fields): void
    {
        if (!self::requestAccepted()) {
            return;
        }

        $userId = (int) ($fields['USER_ID'] ?? $fields['ID'] ?? 0);
        if ($userId <= 0) {
            return;
        }

        self::save('registration', $userId, null, (string) ($fields['EMAIL'] ?? ''));
    }

    public static function onSaleOrderSaved(Event $event): void
    {
        if ($event->getParameter('IS_NEW') !== true || !self::requestAccepted()) {
            return;
        }

        $order = $event->getParameter('ENTITY');
        if (!$order instanceof \Bitrix\Sale\Order || (int) $order->getId() <= 0) {
            return;
        }

        $email = '';
        foreach ($order->getPropertyCollection() as $property) {
            if ((string) $property->getField('CODE') === 'EMAIL') {
                $email = (string) $property->getValue();
                break;
            }
        }

        $source = self::oneClickAccepted() ? 'one_click_order' : 'checkout';
        self::save($source, (int) $order->getUserId(), (int) $order->getId(), $email);
    }

    private static function requestAccepted(): bool
    {
        $request = Application::getInstance()->getContext()->getRequest();
        if ((string) $request->getPost('marketing_consent') === 'Y') {
            return true;
        }

        return self::oneClickAccepted();
    }

    private static function oneClickAccepted(): bool
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $fields = $request->getPost('ORDER_FIELDS');

        return is_array($fields) && (string) ($fields['MARKETING_CONSENT'] ?? '') === 'Y';
    }

    private static function save(string $source, int $userId, ?int $orderId, string $email): void
    {
        try {
            $connection = Application::getConnection();
            $helper = $connection->getSqlHelper();
            $request = Application::getInstance()->getContext()->getRequest();
            $page = (string) $request->getRequestUri();
            $ip = (string) $request->getRemoteAddress();

            $connection->queryExecute(
                'INSERT IGNORE INTO ustage_marketing_consents '
                . '(user_id, order_id, email, source, page, ip, consent_text_hash, created_at) VALUES ('
                . ($userId > 0 ? $userId : 'NULL') . ','
                . ($orderId !== null ? $orderId : 'NULL') . ','
                . "'" . $helper->forSql($email, 255) . "',"
                . "'" . $helper->forSql($source, 32) . "',"
                . "'" . $helper->forSql($page, 255) . "',"
                . "'" . $helper->forSql($ip, 45) . "',"
                . "'" . hash('sha256', self::TEXT) . "',NOW())"
            );
        } catch (Throwable $error) {
            AddMessage2Log('Marketing consent log error: ' . $error->getMessage(), 'ustage.marketing_consent');
        }
    }
}

AddEventHandler('main', 'OnAfterUserRegister', [UstageMarketingConsent::class, 'onAfterUserRegister']);
EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderSaved', [UstageMarketingConsent::class, 'onSaleOrderSaved']);

AddEventHandler('main', 'OnBuildGlobalMenu', static function (&$globalMenu, &$moduleMenu): void {
    global $USER;

    if (!$USER->IsAdmin()) {
        return;
    }

    $moduleMenu[] = [
        'parent_menu' => 'global_menu_services',
        'section' => 'ustage_marketing_consents',
        'sort' => 951,
        'text' => 'Согласия на рассылку',
        'title' => 'Журнал согласий на информационные и рекламные материалы',
        'url' => '/local/admin/marketing_consent_log.php?lang=' . LANGUAGE_ID,
        'more_url' => ['/local/admin/marketing_consent_log.php'],
        'items_id' => 'menu_ustage_marketing_consents',
    ];
});
