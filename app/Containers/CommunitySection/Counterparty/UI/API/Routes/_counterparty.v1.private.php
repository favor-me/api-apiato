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
 *
 * @apiDefine CounterpartySuccessSingleResponse
 * @apiSuccessExample {json} Успешный ответ:
 *
HTTP/1.1 200 OK
{
    "data": {
        "object": "Counterparty",
        "id": "noa8G5O6GybxKjA6",
        "name": "Prof.",
        "legal_address": "88746 Claud Turnpike Suite",
        "mailing_address": "629 Madonna Green Suite 293",
        "phone_number": 16898053307,
        "email": "sienna28@yahoo.com",
        "country": {
            "title": "Россия",
            "name": "rus"
        },
        "bank_data": {
            "bik": "123416434",
            "inn": "1234567891",
            "kpp": "187654321",
            "bank": "BEATAE Bank",
            "okpo": "16547364",
            "orgnip": "123456781098765",
            "payment_account": "12345178909876543212",
            "correspondent_account": "12345678909876513212"
        },
        "organization_id": "rozlAYyzQOd3RqGx",
        "created_at": {
            "timestamp": 1762855857,
            "diff_for_humans": "1 минуту назад",
            "date_for_human": "2025-11-11",
            "date_for_human_full": "11 ноября 2025г.",
            "date_for_human_full_with_time": "11 ноября 2025г. в 13:10:57",
            "iso": "2025-11-11T13:10:57.000000+03:00",
            "time": "13:10:57",
            "timezone": "Europe/Moscow",
            "timezone_type": 3,
            "time_short": "13:10",
            "is_future": false
        },
        "updated_at": {
            "timestamp": 1762855857,
            "diff_for_humans": "1 минуту назад",
            "date_for_human": "2025-11-11",
            "date_for_human_full": "11 ноября 2025г.",
            "date_for_human_full_with_time": "11 ноября 2025г. в 13:10:57",
            "iso": "2025-11-11T13:10:57.000000+03:00",
            "time": "13:10:57",
            "timezone": "Europe/Moscow",
            "timezone_type": 3,
            "time_short": "13:10",
            "is_future": false
        },
        "deleted_at": null,
        "bank_data_schema": {
            "inn": {
                "type": "int",
                "name": "inn",
                "title": "ИНН",
                "value": "1234567891"
            },
            "kpp": {
                "type": "int",
                "name": "kpp",
                "title": "КПП",
                "value": "187654321"
            },
            "orgnip": {
                "type": "int",
                "name": "orgnip",
                "title": "ОРГНИП",
                "value": "123456781098765"
            },
            "payment_account": {
                "type": "int",
                "name": "payment_account",
                "title": "Расчётный счёт",
                "value": "12345178909876543212"
            },
            "bank": {
                "type": "string",
                "name": "bank",
                "title": "Название банка",
                "value": "BEATAE Bank"
            },
            "correspondent_account": {
                "type": "int",
                "name": "correspondent_account",
                "title": "Кор. счёт",
                "value": "12345678909876513212"
            },
            "bik": {
                "type": "int",
                "name": "bik",
                "title": "БИК",
                "value": "123416434"
            },
            "okpo": {
                "type": "int",
                "name": "okpo",
                "title": "ОКПО",
                "value": "16547364"
            },
            "okved": {
                "type": "string",
                "name": "okved",
                "title": "ОКВЭД",
                "value": null
            },
            "okato": {
                "type": "int",
                "name": "okato",
                "title": "ОКАТО",
                "value": null
            }
        }
    },
    "meta": {
        "include": []
    }
}
 */
