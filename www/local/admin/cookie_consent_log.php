<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';

use Bitrix\Main\Application;

global $APPLICATION, $USER;

if (!$USER->IsAdmin()) {
    $APPLICATION->AuthForm('Доступ разрешён только администраторам.');
}

$APPLICATION->SetTitle('Решения по cookie');

$connection = Application::getConnection();
$helper = $connection->getSqlHelper();
$decision = (string) ($_GET['decision'] ?? '');
if ($decision !== 'accepted' && $decision !== 'rejected') {
    $decision = '';
}

$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 100;
$offset = ($page - 1) * $perPage;
$where = $decision === '' ? '' : " WHERE decision = '" . $helper->forSql($decision) . "'";
$total = (int) $connection->queryScalar('SELECT COUNT(*) FROM ustage_cookie_consents' . $where);
$pages = max(1, (int) ceil($total / $perPage));
if ($page > $pages) {
    $page = $pages;
    $offset = ($page - 1) * $perPage;
}

$rows = $connection->query(
    'SELECT id, consent_id, decision, page, user_id, created_at, updated_at '
    . 'FROM ustage_cookie_consents'
    . $where
    . ' ORDER BY updated_at DESC, id DESC'
    . ' LIMIT ' . $perPage . ' OFFSET ' . $offset
);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php';

function cookieConsentAdminUrl(int $page, string $decision): string
{
    $query = ['lang' => LANGUAGE_ID, 'page' => $page];
    if ($decision !== '') {
        $query['decision'] = $decision;
    }

    return '/local/admin/cookie_consent_log.php?' . http_build_query($query);
}
?>

<form method="get" action="/local/admin/cookie_consent_log.php" style="margin-bottom: 16px;">
    <input type="hidden" name="lang" value="<?=htmlspecialcharsbx(LANGUAGE_ID)?>">
    <label for="cookie-decision-filter">Решение:</label>
    <select id="cookie-decision-filter" name="decision">
        <option value="">Все</option>
        <option value="accepted"<?=$decision === 'accepted' ? ' selected' : ''?>>Принято</option>
        <option value="rejected"<?=$decision === 'rejected' ? ' selected' : ''?>>Отказ</option>
    </select>
    <button type="submit" class="adm-btn">Применить</button>
</form>

<p>Всего записей: <strong><?=$total?></strong>. На один браузер хранится одна строка; повторный выбор обновляет её.</p>

<div class="adm-list-table-wrap">
    <table class="adm-list-table">
        <thead>
        <tr class="adm-list-table-header">
            <td class="adm-list-table-cell"><div class="adm-list-table-cell-inner">ID</div></td>
            <td class="adm-list-table-cell"><div class="adm-list-table-cell-inner">Решение</div></td>
            <td class="adm-list-table-cell"><div class="adm-list-table-cell-inner">Идентификатор браузера</div></td>
            <td class="adm-list-table-cell"><div class="adm-list-table-cell-inner">Пользователь</div></td>
            <td class="adm-list-table-cell"><div class="adm-list-table-cell-inner">Страница</div></td>
            <td class="adm-list-table-cell"><div class="adm-list-table-cell-inner">Первый выбор</div></td>
            <td class="adm-list-table-cell"><div class="adm-list-table-cell-inner">Обновлено</div></td>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $rows->fetch()): ?>
            <tr class="adm-list-table-row">
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['id'])?></td>
                <td class="adm-list-table-cell"><?=$row['decision'] === 'accepted' ? 'Принято' : 'Отказ'?></td>
                <td class="adm-list-table-cell"><code><?=htmlspecialcharsbx((string) $row['consent_id'])?></code></td>
                <td class="adm-list-table-cell">
                    <?php if ((int) $row['user_id'] > 0): ?>
                        <a href="/bitrix/admin/user_edit.php?lang=<?=urlencode(LANGUAGE_ID)?>&amp;ID=<?=(int) $row['user_id']?>"><?=(int) $row['user_id']?></a>
                    <?php else: ?>
                        гость
                    <?php endif; ?>
                </td>
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['page'])?></td>
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['created_at'])?></td>
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['updated_at'])?></td>
            </tr>
        <?php endwhile; ?>
        <?php if ($total === 0): ?>
            <tr class="adm-list-table-row">
                <td class="adm-list-table-cell" colspan="7">Записей пока нет.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($pages > 1): ?>
    <div style="margin-top: 16px;">
        <?php if ($page > 1): ?>
            <a class="adm-btn" href="<?=htmlspecialcharsbx(cookieConsentAdminUrl($page - 1, $decision))?>">← Назад</a>
        <?php endif; ?>
        <span style="margin: 0 12px;">Страница <?=$page?> из <?=$pages?></span>
        <?php if ($page < $pages): ?>
            <a class="adm-btn" href="<?=htmlspecialcharsbx(cookieConsentAdminUrl($page + 1, $decision))?>">Вперёд →</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php'; ?>
