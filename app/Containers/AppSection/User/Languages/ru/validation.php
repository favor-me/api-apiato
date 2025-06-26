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
 */

return [
    'exists_with_role' => 'Пользователь не найден.',
    'login' => [
        'unique' => 'Указанный логин занят.',
    ],
    'name' => [
        'min' => 'Имя должно состоять минимум из :min-x символов',
    ],
    'patronymic' => [
        'min' => 'Отчество должно состоять минимум из :min-x символов',
    ],
    'surname' => [
        'min' => 'Фимилия должна состоять минимум из :min-x символов',
    ],
    'token' => [
        'required' => 'Токен - обязательное поле для заполнения.',
    ],
];
