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
 * @apiDefine ItemSuccessSingleResponse
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "data": {
        "object": "Item",
        "id": "6DABL4N24OP53zeM",
        "shift_id": "noa8G5O6GybxKjA6",
        "order_id": null,
        "type": {
            "title": "Заработок",
            "name": "income"
        },
        "value": {
            "currency": {
            "value": 0,
                "symbol": "руб.",
                "text": "0,00 руб.",
                "no_style": "0,00",
                "rule": "currency"
            },
            "exchange": {
            "value": 0,
                "symbol": "коп.",
                "text": "0 коп.",
                "no_style": "0",
                "rule": "exchange"
            }
        },
        "description": null,
        "created_by": "Q9V2RLOKZ0wEm1qY",
        "created_at": {
            "timestamp": 1772737596,
            "diff_for_humans": "1 секунду назад",
            "date_for_human": "05.03.2026",
            "date_for_human_full": "05 марта 2026г.",
            "date_for_human_full_with_time": "05 марта 2026г. в 23:06:36",
            "iso": "2026-03-05T23:06:36.000000+04:00",
            "time": "23:06:36",
            "timezone": "Europe/Saratov",
            "timezone_type": 3,
            "timezone_utc": "+04:00",
            "time_short": "23:06",
            "is_future": false
        },
        "updated_at": {
            "timestamp": 1772737596,
            "diff_for_humans": "1 секунду назад",
            "date_for_human": "05.03.2026",
            "date_for_human_full": "05 марта 2026г.",
            "date_for_human_full_with_time": "05 марта 2026г. в 23:06:36",
            "iso": "2026-03-05T23:06:36.000000+04:00",
            "time": "23:06:36",
            "timezone": "Europe/Saratov",
            "timezone_type": 3,
            "timezone_utc": "+04:00",
            "time_short": "23:06",
            "is_future": false
        }
    },
    "meta": {
        "include": [
            "creator",
            "shift",
            "order"
        ]
    }
}
 */
