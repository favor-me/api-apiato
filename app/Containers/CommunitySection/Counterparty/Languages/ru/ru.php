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
    'title' => 'Россия',
    'inn' => [
        'title' => 'ИНН',
        'rules' => [
            'required' => 'ИНН обязательно для заполнения.',
            'numeric' => 'ИНН может состоять только из цифр.',
            'min_digits' => 'ИНН должно содержать не менее :digits цифр.',
            'max_digits' => 'ИНН не может содержать более :digits цифр.',
        ]
    ],
    'okpo' => [
        'title' => 'ОКПО',
        'desc' => 'Общероссийский классификатор предприятий и организаций',
        'rules' => [
            'required' => 'ОКПО обязательно для заполнения.',
            'numeric' => 'ОКПО может состоять только из цифр.',
            'min_digits' => 'ОКПО должно содержать не менее :digits цифр.',
            'max_digits' => 'ОКПО не может содержать более :digits цифр.',
        ]
    ],
    'kpp' => [
        'title' => 'КПП',
        'desc' => 'Код причины постановки на учёт',
        'rules' => [
            'required' => 'КПП обязателен для заполнения.',
            'numeric' => 'КПП может состоять только из цифр.',
            'digits' => 'КПП должно содержать :digits цифр.',
        ]
    ],
    'orgnip' => [
        'title' => 'ОРГНИП',
        'desc' => 'Основной государственный регистрационный номер юр. лица',
        'rules' => [
            'required' => 'ОРГНИП обязателен для заполнения.',
            'numeric' => 'ОРГНИП может состоять только из цифр.',
            'digits' => 'ОРГНИП должно содержать :digits цифр.',
        ]
    ],
    'bik' => [
        'title' => 'БИК',
        'desc' => 'Банковский идентификационный код',
        'rules' => [
            'required' => 'БИК обязателен для заполнения.',
            'numeric' => 'БИК может состоять только из цифр.',
            'digits' => 'БИК должно содержать :digits цифр.',
        ]
    ],
    'payment_account' => [
        'title' => 'Расчётный счёт',
        'desc' => 'Расчётный счёт',
        'rules' => [
            'required' => 'Расчётный счёт обязателен для заполнения.',
            'numeric' => 'Расчётный счёт может состоять только из цифр.',
            'digits' => 'Расчётный счёт должно содержать :digits цифр.',
        ]
    ],
    'correspondent_account' => [
        'title' => 'Кор. счёт',
        'desc' => 'Корреспондентский счёт',
        'rules' => [
            'required' => 'Кор. счёт обязателен для заполнения.',
            'numeric' => 'Кор. счёт может состоять только из цифр.',
            'digits' => 'Кор. счёт должно содержать :digits цифр.',
        ]
    ],
    'bank' => [
        'title' => 'Название банка',
        'desc' => 'Название банка',
        'rules' => [
            'required' => 'Название банка обязательно для заполнения.',
            'max' => 'Название банка не должно привышать :max символов',
        ]
    ],
    'okved' => [
        'title' => 'ОКВЭД',
        'desc' => 'Общероссийский классификатор видов экономической деятельности',
        'rules' => [
            'max' => 'ОКВЭД не должно привышать :max символов',
        ]
    ],
    'okato' => [
        'title' => 'ОКАТО',
        'desc' => 'Общероссийский классификатор административно-территориальных образований',
        'rules' => [
            'numeric' => 'ОКАТО может состоять только из цифр.',
            'min_digits' => 'ОКАТО должно содержать не менее :digits цифр.',
            'max_digits' => 'ОКАТО не может содержать более :digits цифр.',
        ]
    ],
];
