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
    'name' => 'Контрагенты',
    'items' => 'Контрагент|Контрагента|Контрагентов',
    'validation' => [
        'exists_country' => 'Не верное значение для страны. Доступные значения :countries',
        'name' => [
            'unique' => 'Контрагент с таким именем уже существует.'
        ],
        'legal_address' => [
            'required' => 'Юридический адрес обязателен для заполнения.'
        ],
        'mailing_address' => [
            'required' => 'Почтовый адрес обязателен для заполнения.'
        ],
        'ownership_type' => [
            'required' => 'Тип собственности обязателен для заполения'
        ]
    ]
];
