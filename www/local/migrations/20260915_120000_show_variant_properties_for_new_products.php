<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;

return static function (Connection $connection): void {
    // A new element without a selected section uses section 0 property links.
    // Keep existing section-specific links and values unchanged.
    foreach ([8653 => 'ISTOCHNIK_SVETA', 8654 => 'STEPEN_ZASHITY'] as $propertyId => $code) {
        $row = $connection->query(
            'SELECT ID FROM b_iblock_property WHERE ID = ' . $propertyId
            . " AND IBLOCK_ID = 32 AND CODE = '" . $code . "'"
            . " AND PROPERTY_TYPE = 'L' AND ACTIVE = 'Y'"
        )->fetch();
        if (!$row) {
            throw new RuntimeException('Expected list property is missing: ' . $code);
        }

        $connection->queryExecute(
            'INSERT IGNORE INTO b_iblock_section_property '
            . '(IBLOCK_ID, SECTION_ID, PROPERTY_ID, SMART_FILTER, DISPLAY_TYPE) VALUES '
            . '(32, 0, ' . $propertyId . ", 'N', 'F')"
        );
    }
};
