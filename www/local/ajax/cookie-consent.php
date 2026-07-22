<?php

declare(strict_types=1);

define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Application;

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(['ok' => false]);
    exit;
}

if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest') {
    http_response_code(403);
    echo json_encode(['ok' => false]);
    exit;
}

$consentId = strtolower(trim((string) ($_POST['consent_id'] ?? '')));
$decision = (string) ($_POST['decision'] ?? '');
$page = (string) ($_POST['page'] ?? '/');

if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}$/', $consentId)) {
    http_response_code(422);
    echo json_encode(['ok' => false]);
    exit;
}

if ($decision !== 'accepted' && $decision !== 'rejected') {
    http_response_code(422);
    echo json_encode(['ok' => false]);
    exit;
}

$pagePath = parse_url($page, PHP_URL_PATH);
if (!is_string($pagePath) || $pagePath === '' || $pagePath[0] !== '/') {
    $pagePath = '/';
}
$pagePath = mb_substr($pagePath, 0, 255);

$connection = Application::getConnection();
$helper = $connection->getSqlHelper();
$userId = $GLOBALS['USER']->IsAuthorized() ? (int) $GLOBALS['USER']->GetID() : null;

$connection->queryExecute(
    'INSERT INTO ustage_cookie_consents '
    . '(consent_id, decision, page, user_id, created_at, updated_at) VALUES ('
    . "'" . $helper->forSql($consentId) . "',"
    . "'" . $helper->forSql($decision) . "',"
    . "'" . $helper->forSql($pagePath) . "',"
    . ($userId === null ? 'NULL' : (string) $userId) . ','
    . 'NOW(), NOW()) '
    . 'ON DUPLICATE KEY UPDATE '
    . 'decision = VALUES(decision), '
    . 'page = VALUES(page), '
    . 'user_id = VALUES(user_id), '
    . 'updated_at = NOW()'
);

echo json_encode(['ok' => true]);
