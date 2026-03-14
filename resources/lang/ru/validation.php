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

return [
    'custom' => [
        'id' => [
            'required' => 'Вы не указали id.',
            'exists' => 'Выбранный id не существует.'
        ],
        'ids' => [
            'exists' => 'Выбранные значения не найдены.',
            'required' => 'Ни одно значение не найдено.',
            '*' => [
                'required' => 'Ни одно значение не найдено.',
                'exists' => 'Выбранное значение не найдено.'
            ]
        ],
        'email' => [
            'required' => 'Email адрес обязателен для заполнения.',
            'email' => 'Укажите корректный email адрес.',
            'unique' => 'Электронная почта уже занята.'
        ],
        'password' => [
            'required' => 'Пароль обязателен к заполнению.',
            'min' => 'Минимальная длинна пароля :min символов',
        ],
        'published' => [
            'boolean' => 'Статус публикации необходимо указывать в boolean типе. (true, false, 1, 0)'
        ],
        'name' => [
            'required' => 'Имя обязательно к заполнению.',
            'min' => 'Минимальная длинна имени :min символа',
            'max' => 'Максимальная длинна имени :max символа',
        ],
        'surname' => [
            'required' => 'Фамилия обязательно к заполнению.'
        ],
        'patronymic' => [
            'required' => 'Отчество обязательно к заполнению.'
        ],
        'role' => [
            'exists' => 'Указанная роль не существует.'
        ],
        'gender' => [
            'boolean' => 'Значение пола должно быть true или false. Где true - мужчина, false - женщина.'
        ],
        'birth' => [
            'date' => 'День рождения должно быть реальной датой в формате DD.MM.YYYY.'
        ],
        'created_by' => [
            'exists' => 'Пользователь не найден.'
        ],
        'slug' => [
            'min' => 'Минимальная длинна псевдонима :min символа',
            'max' => 'Максимальная длинна псевдонима :max символа',
            'unique' => 'Псевдоним уже занята.'
        ],
        'description' => [
            'string' => 'Описание должно быть в виде строки.'
        ],
        'price' => [
            'integer' => 'Цена должна быть в виде числа.'
        ],
        'phone_number' => [
            'unique' => 'Номер телефона уже занят.',
            'required' => 'Необходимо указать номер телефона.'
        ]
    ],
    'exists' => 'Выбранный :attribute недействителен.',
    'array' => 'Значение :attribute должно быть массивом.',
    'image' => 'Значение :attribute должно быть изображением.',
    'mimes' => ':attribute должен быть файлом типа :values.',
    'date_format' => 'Значение :attribute не соответствует формату :format.',
    'after_or_equal' => 'Значение :attribute должно быть датой после или равной :date.',
    'gt' => [
        'numeric' => 'Значение :attribute должно быть больше :value.'
    ],
    'max' => [
        'numeric' => 'Значение :attribute не может быть больше :max.',
        'file' => 'Файл :attribute не должен привышать размер :max килобайт.',
    ],
    'required' => 'Значение для поля :attribute обязательное.',
    'min' => [
        'array' => 'Значение для поля :attribute как минимум :min символ(а/ов).',
    ],
    'phone' => [
        'real_number' => 'Введите корректный номер телефона'
    ],
    'time' => 'Не верный формат :attribute'
];
