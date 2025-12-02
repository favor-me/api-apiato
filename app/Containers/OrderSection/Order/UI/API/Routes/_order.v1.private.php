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
 * @apiDefine OrderSuccessSingleResponse
 * @apiSuccessExample {json} Успешный ответ:
 HTTP/1.1 200 OK
{
    "data": {
        "object": "Order",
        "id": "rozlAYyzQOd3RqGx",
        "organization_id": "Ab9G2gOomNdWkKEz",
        "oid": 2,
        "status_id": null,
        "payment_type": {
            "title": "Наличные",
            "name": "cash"
        },
        "total": {
            "currency": {
                "value": 230,
                "symbol": "руб.",
                "text": "230,00 руб.",
                "no_style": "230,00",
                "rule": "currency"
            },
            "exchange": {
                "value": 23000,
                "symbol": "коп.",
                "text": "23 000 коп.",
                "no_style": "23 000",
                "rule": "exchange"
            }
        },
        "profit": {
            "currency": {
                "value": 220,
                "symbol": "руб.",
                "text": "220,00 руб.",
                "no_style": "220,00",
                "rule": "currency"
            },
            "exchange": {
                "value": 22000,
                "symbol": "коп.",
                "text": "22 000 коп.",
                "no_style": "22 000",
                "rule": "exchange"
            }
        },
        "comment": null,
        "client_id": "noa8G5O6GybxKjA6",
        "counterparty_id": null,
        "contract_id": null,
        "created_by": "Q9V2RLOKZ0wEm1qY",
        "updated_by": "Q9V2RLOKZ0wEm1qY",
        "created_at": {
            "timestamp": 1758836186,
            "diff_for_humans": "2 недели назад",
            "date_for_human": "2025-09-26",
            "date_for_human_full": "26 сентября 2025г.",
            "date_for_human_full_with_time": "26 сентября 2025г. в 00:36:26",
            "iso": "2025-09-26T00:36:26.000000+03:00",
            "time": "00:36:26",
            "timezone": "Europe/Moscow",
            "timezone_type": 3,
            "time_short": "00:36",
            "is_future": false
        },
        "updated_at": {
            "timestamp": 1760051295,
            "diff_for_humans": "1 день назад",
            "date_for_human": "2025-10-10",
            "date_for_human_full": "10 октября 2025г.",
            "date_for_human_full_with_time": "10 октября 2025г. в 02:08:15",
            "iso": "2025-10-10T02:08:15.000000+03:00",
            "time": "02:08:15",
            "timezone": "Europe/Moscow",
            "timezone_type": 3,
            "time_short": "02:08",
            "is_future": false
        },
        "deleted_at": null,
        "items": {
            "data": [
                {
                    "object": "Item",
                    "id": "rozlAYyzkQNd3RqG",
                    "order_id": "rozlAYyzQOd3RqGx",
                    "unit_id": "mPMkKZOVky79ELAX",
                    "name": "Клапан",
                    "sku": null,
                    "cost_price": {
                        "currency": {
                            "value": 10,
                            "symbol": "руб.",
                            "text": "10,00 руб.",
                            "no_style": "10,00",
                            "rule": "currency"
                        },
                        "exchange": {
                            "value": 1000,
                            "symbol": "коп.",
                            "text": "1 000 коп.",
                            "no_style": "1 000",
                            "rule": "exchange"
                        }
                    },
                    "client_price": {
                        "currency": {
                            "value": 20,
                            "symbol": "руб.",
                            "text": "20,00 руб.",
                            "no_style": "20,00",
                            "rule": "currency"
                        },
                        "exchange": {
                            "value": 2000,
                            "symbol": "коп.",
                            "text": "2 000 коп.",
                            "no_style": "2 000",
                            "rule": "exchange"
                            }
                    },
                    "amount": 1
                }
            ]
        }
    },
    "meta": {
        "include": [
            "client",
            "creator",
            "updater",
            "status",
            "contract",
            "counterparty",
            "organization"
        ]
    }
}
 */
