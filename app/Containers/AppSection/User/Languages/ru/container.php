<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

return [
    'name' => 'Пользователи',
    'items' => 'Пользователь|Пользователя|Пользователей',
    'shift_params' => [
        'fix_rate' => [
            'title' => 'Фикс. ставка смены',
            'hint' => 'Фиксированная ставка смены.',
            'validation' => [
                'number' => 'Фикс. ставка смены должно быть числом.'
            ]
        ],
        'percent_from_order_profit' => [
            'title' => 'Процент прибыли заказа',
            'hint' => 'При завершении заказа процент от прибыли будет начисляться на счёт смены.',
            'validation' => [
                'number' => 'Процент прибыли заказа должен быть числом.'
            ]
        ]
    ]
];
