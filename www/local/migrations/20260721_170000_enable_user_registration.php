<?php

declare(strict_types=1);

use Bitrix\Main\Config\Option;
use Bitrix\Main\DB\Connection;

return static function (Connection $connection): void {
    if (Option::get('main', 'new_user_registration', 'N') !== 'Y') {
        Option::set('main', 'new_user_registration', 'Y');
    }

    if (Option::get('main', 'captcha_registration', 'N') !== 'Y') {
        Option::set('main', 'captcha_registration', 'Y');
    }
};
