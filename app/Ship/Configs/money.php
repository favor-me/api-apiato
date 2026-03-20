<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

use App\Ship\SimpleTypes\Config\Money;

return [
    'debug' => env('MONEY_DEBUG', false),
    'num_decimals' => env('MONEY_NUM_DECIMALS', 2),
    'decimal_sep' => env('MONEY_DECIMAL_SEP', '.'),
    'thousands_sep' => env('MONEY_THOUSAND_SEP', ' '),
    'default_currency' => 'rub',
    'currencies' => [
        'rub' => [
            Money::CURRENCY => 'руб.',
            Money::EXCHANGE => 'коп.'
        ],
        'byn' => [
            Money::CURRENCY => 'руб.',
            Money::EXCHANGE => 'коп.'
        ],
        'uah' => [
            Money::CURRENCY => 'грн.',
            Money::EXCHANGE => 'коп.'
        ],
        'kzt' => [
            Money::CURRENCY => 'тенге',
            Money::EXCHANGE => 'тиын'
        ]
    ]
];
