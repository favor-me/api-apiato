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
    'name' => 'Смены',
    'items' => 'Смена|Смены|Смен',
    'invalid_shift_date_time' => 'Невозможно создать смену с указанным диапозоном времени.',
    'status' => [
        'open' => [
            'title' => 'Открыта'
        ],
        'completed' => [
            'title' => 'Завершена'
        ],
        'unknown' => [
            'title' => 'Неизвестно'
        ],
        'confirmed' => [
            'title' => 'Подтверждена'
        ],
        'paid' => [
            'title' => 'Оплачена'
        ]
    ],
    'validation' => [
        'finish_at' => [
            'after' => 'Дата завершения смены должна быть больше даты начала',
            'before_or_equal' => 'Дата завершения не может быть больше даты :date.'
        ],
        'start_at' => [
            'before_or_equal' => 'Дата начала не может быть больше даты :date.'
        ]
    ]
];
