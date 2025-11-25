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
 * @apiDefine ContractSuccessSingleResponse
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "data": {
        "object": "Contract",
            "id": "GLkZWENgVyj7ePgV",
            "name": "Тест",
            "number": 18,
            "counterparty_id": "noa8G5O6GybxKjA6",
            "organization_id": "Ab9G2gOomNdWkKEz",
            "start_at": {
                "timestamp": 1763154000,
                "date_for_human": "15.11.2025",
                "date_for_human_full": "15 ноября 2025г.",
                "iso": "2025-11-15T00:00:00.000000+03:00",
                "timezone": "Europe/Moscow",
                "timezone_type": 3,
                "is_future": false
            },
            "finish_at": {
                "timestamp": 1763240400,
                "date_for_human": "16.11.2025",
                "date_for_human_full": "16 ноября 2025г.",
                "iso": "2025-11-16T00:00:00.000000+03:00",
                "timezone": "Europe/Moscow",
                "timezone_type": 3,
                "is_future": false
            },
            "created_at": {
                "timestamp": 1763243185,
                "diff_for_humans": "1 секунду назад",
                "date_for_human": "16.11.2025",
                "date_for_human_full": "16 ноября 2025г.",
                "date_for_human_full_with_time": "16 ноября 2025г. в 00:46:25",
                "iso": "2025-11-16T00:46:25.000000+03:00",
                "time": "00:46:25",
                "timezone": "Europe/Moscow",
                "timezone_type": 3,
                "time_short": "00:46",
                "is_future": false
            },
            "is_live_now": false,
            "updated_at": {
                "timestamp": 1763243185,
                "diff_for_humans": "1 секунду назад",
                "date_for_human": "16.11.2025",
                "date_for_human_full": "16 ноября 2025г.",
                "date_for_human_full_with_time": "16 ноября 2025г. в 00:46:25",
                "iso": "2025-11-16T00:46:25.000000+03:00",
                "time": "00:46:25",
                "timezone": "Europe/Moscow",
                "timezone_type": 3,
                "time_short": "00:46",
                "is_future": false
            },
            "deleted_at": null,
            "counterparty": {
                "data": {
                    "object": "Counterparty",
                    "id": "noa8G5O6GybxKjA6",
                    "number": 1,
                    "name": "Mr.",
                    "legal_address": "6723 Wolff Curve Suite 457\nEast Loma, MT 84655",
                    "mailing_address": "86264 Jerde Drive\nHoseahaven, VT 78357-2214",
                    "phone_number": 18656318782,
                    "email": "areichert@hotmail.com",
                    "country": {
                    "title": "Россия",
                        "name": "rus"
                    },
                    "bank_data": {
                    "inn": "1234567896",
                        "kpp": "687654321",
                        "orgnip": "123456786098765",
                        "payment_account": "12345678909876543212",
                        "correspondent_account": "12345678909876563212",
                        "bank": "VOLUPTATUM Bank",
                        "bik": "123466434",
                        "okpo": "66547364"
                    },
                    "organization_id": "Ab9G2gOomNdWkKEz",
                    "created_at": {
                    "timestamp": 1762872097,
                        "diff_for_humans": "4 дня назад",
                        "date_for_human": "11.11.2025",
                        "date_for_human_full": "11 ноября 2025г.",
                        "date_for_human_full_with_time": "11 ноября 2025г. в 17:41:37",
                        "iso": "2025-11-11T17:41:37.000000+03:00",
                        "time": "17:41:37",
                        "timezone": "Europe/Moscow",
                        "timezone_type": 3,
                        "time_short": "17:41",
                        "is_future": false
                    },
                    "updated_at": {
                    "timestamp": 1762944998,
                        "diff_for_humans": "3 дня назад",
                        "date_for_human": "12.11.2025",
                        "date_for_human_full": "12 ноября 2025г.",
                        "date_for_human_full_with_time": "12 ноября 2025г. в 13:56:38",
                        "iso": "2025-11-12T13:56:38.000000+03:00",
                        "time": "13:56:38",
                        "timezone": "Europe/Moscow",
                        "timezone_type": 3,
                        "time_short": "13:56",
                        "is_future": false
                    },
                    "deleted_at": null,
                    "bank_data_schema": [
                        {
                            "type": "int",
                            "name": "inn",
                            "title": "ИНН",
                            "value": "1234567896",
                            "rules": [
                                "required",
                                "numeric",
                                "min_digits:10",
                                "max_digits:12"
                            ]
                        },
                        {
                            "type": "int",
                            "name": "kpp",
                            "title": "КПП",
                            "value": "687654321",
                            "rules": [
                                "required",
                                "numeric",
                                "digits:9"
                            ]
                        },
                        {
                            "type": "int",
                            "name": "orgnip",
                            "title": "ОРГНИП",
                            "value": "123456786098765",
                            "rules": [
                                "required",
                                "numeric",
                                "digits:15"
                            ]
                        },
                        {
                            "type": "int",
                            "name": "payment_account",
                            "title": "Расчётный счёт",
                            "value": "12345678909876543212",
                            "rules": [
                                "required",
                                "numeric",
                                "digits:20"
                            ]
                        },
                        {
                            "type": "string",
                            "name": "bank",
                            "title": "Название банка",
                            "value": "VOLUPTATUM Bank",
                            "rules": [
                                "required",
                                "string",
                                "max:50"
                            ]
                        },
                        {
                            "type": "int",
                            "name": "correspondent_account",
                            "title": "Кор. счёт",
                            "value": "12345678909876563212",
                            "rules": [
                                "required",
                                "numeric",
                                "digits:20"
                            ]
                        },
                        {
                            "type": "int",
                            "name": "bik",
                            "title": "БИК",
                            "value": "123466434",
                            "rules": [
                                "required",
                                "numeric",
                                "digits:9"
                            ]
                        },
                        {
                            "type": "int",
                            "name": "okpo",
                            "title": "ОКПО",
                            "value": "66547364",
                            "rules": [
                            "required",
                                "numeric",
                                "min_digits:8",
                                "max_digits:10"
                            ]
                        },
                        {
                            "type": "string",
                            "name": "okved",
                            "title": "ОКВЭД",
                            "value": null,
                            "rules": [
                                "string",
                                "nullable",
                                "max:50"
                            ]
                        },
                        {
                            "type": "int",
                            "name": "okato",
                            "title": "ОКАТО",
                            "value": null,
                            "rules": [
                            "numeric",
                                "nullable",
                                "min_digits:2",
                                "max_digits:11"
                            ]
                        }
                    ]
                }
            }
        },
        "meta": {
            "include": [
                "unit_prices",
                "organization"
            ]
    }
}
*/
