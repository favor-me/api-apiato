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
    'name' => [
        'required' => 'Название организации обязательно для заполнения',
        'unique' => 'Организация была зарегистрирована ранее'
    ],
    'ownership_type' => [
        'required' => 'Укажите тип собственности'
    ],
    'phone_number' => [
        'required' => 'Необходимо указать контактный номер телефона'
    ],
    'country' => [
        'required' => 'Укажите страну'
    ],
    'owner_name' => [
        'required' => 'Укажите имя'
    ],
    'email' => [
        'required' => 'Укажите адрес электронной почты'
    ],
    'is_owner_name' => 'Не верно указано ФИО',
    'unique_organization' => 'Организация была зарегистрирована ранее'
];
