<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';

use Bitrix\Main\Application;

global $APPLICATION, $USER;

if (!$USER->IsAdmin()) {
    $APPLICATION->AuthForm('Доступ разрешён только администраторам.');
}

$APPLICATION->SetTitle('Согласия на рассылку');
$connection = Application::getConnection();
$total = (int) $connection->queryScalar('SELECT COUNT(*) FROM ustage_marketing_consents');
$rows = $connection->query(
    'SELECT id, user_id, order_id, email, source, page, ip, created_at '
    . 'FROM ustage_marketing_consents ORDER BY created_at DESC, id DESC LIMIT 500'
);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php';
?>
<p>Всего согласий: <strong><?=$total?></strong>. Показаны последние 500.</p>
<div class="adm-list-table-wrap">
    <table class="adm-list-table">
        <thead><tr class="adm-list-table-header">
            <?php foreach (['ID', 'Дата', 'Источник', 'Пользователь', 'Заказ', 'Email', 'IP', 'Страница'] as $title): ?>
                <td class="adm-list-table-cell"><div class="adm-list-table-cell-inner"><?=htmlspecialcharsbx($title)?></div></td>
            <?php endforeach; ?>
        </tr></thead>
        <tbody>
        <?php while ($row = $rows->fetch()): ?>
            <tr class="adm-list-table-row">
                <td class="adm-list-table-cell"><?=(int) $row['id']?></td>
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['created_at'])?></td>
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['source'])?></td>
                <td class="adm-list-table-cell"><?=(int) $row['user_id'] > 0 ? '<a href="/bitrix/admin/user_edit.php?lang=' . urlencode(LANGUAGE_ID) . '&amp;ID=' . (int) $row['user_id'] . '">' . (int) $row['user_id'] . '</a>' : 'гость'?></td>
                <td class="adm-list-table-cell"><?=(int) $row['order_id'] > 0 ? '<a href="/bitrix/admin/sale_order_view.php?lang=' . urlencode(LANGUAGE_ID) . '&amp;ID=' . (int) $row['order_id'] . '">' . (int) $row['order_id'] . '</a>' : '—'?></td>
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['email'])?></td>
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['ip'])?></td>
                <td class="adm-list-table-cell"><?=htmlspecialcharsbx((string) $row['page'])?></td>
            </tr>
        <?php endwhile; ?>
        <?php if ($total === 0): ?><tr class="adm-list-table-row"><td class="adm-list-table-cell" colspan="8">Записей пока нет.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php'; ?>
