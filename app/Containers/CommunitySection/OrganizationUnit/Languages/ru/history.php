<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 *
 * @codingStandardsIgnoreStart
 */

return [
    'plus_organization_unit_balance' => [
        'note_message' => 'Обновлено значение баланса. Предыдущее значение «:old_value», новое значение «:new_value».',
        'infinity_note_message' => 'Установлено неограниченное значение баланса.'
    ],
    'minus_organization_unit_balance' => [
        'note_message' => 'Списание баланса из заказа №:order_id. Предыдущее значение «:old_value», новое значение «:new_value».',
        'infinity_note_message' => 'Списание баланса(-:minus_balance) из заказа №:order_number.'
    ]
];
