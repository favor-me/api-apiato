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
 * HTTP/1.1 200 OK
 * {
 * "data": {
 * "object": "Order",
 * "id": "noa8G5O6GybxKjA6",
 * "organization_id": "Ab9G2gOomNdWkKEz",
 * "oid": 1,
 * "payment_type": {
 * "title": "Наличные",
 * "name": "cash"
 * },
 * "total": {
 * "currency": {
 * "value": 300,
 * "symbol": "руб.",
 * "text": "300,00 руб.",
 * "no_style": "300,00",
 * "rule": "currency"
 * },
 * "exchange": {
 * "value": 30000,
 * "symbol": "коп.",
 * "text": "30 000 коп.",
 * "no_style": "30 000",
 * "rule": "exchange"
 * }
 * },
 * "profit": {
 * "currency": {
 * "value": 300,
 * "symbol": "руб.",
 * "text": "300,00 руб.",
 * "no_style": "300,00",
 * "rule": "currency"
 * },
 * "exchange": {
 * "value": 30000,
 * "symbol": "коп.",
 * "text": "30 000 коп.",
 * "no_style": "30 000",
 * "rule": "exchange"
 * }
 * },
 * "comment": null,
 * "client_id": "noa8G5O6GybxKjA6",
 * "created_by": "Q9V2RLOKZ0wEm1qY",
 * "updated_by": "Q9V2RLOKZ0wEm1qY",
 * "created_at": {
 * "timestamp": 1758385422,
 * "diff_for_humans": "2 недели назад",
 * "date_for_human": "2025-09-20",
 * "date_for_human_full": "20 сентября 2025г.",
 * "date_for_human_full_with_time": "20 сентября 2025г. в 19:23:42",
 * "iso": "2025-09-20T19:23:42.000000+03:00",
 * "time": "19:23:42",
 * "timezone": "Europe/Moscow",
 * "timezone_type": 3,
 * "time_short": "19:23",
 * "is_future": false
 * },
 * "updated_at": {
 * "timestamp": 1758385422,
 * "diff_for_humans": "2 недели назад",
 * "date_for_human": "2025-09-20",
 * "date_for_human_full": "20 сентября 2025г.",
 * "date_for_human_full_with_time": "20 сентября 2025г. в 19:23:42",
 * "iso": "2025-09-20T19:23:42.000000+03:00",
 * "time": "19:23:42",
 * "timezone": "Europe/Moscow",
 * "timezone_type": 3,
 * "time_short": "19:23",
 * "is_future": false
 * },
 * "deleted_at": null,
 * "items": {
 * "data": [
 * {
 * "object": "Item",
 * "id": "noa8G5O6GybxKjA6",
 * "order_id": "noa8G5O6GybxKjA6",
 * "unit_id": "rozlAYyzQOd3RqGx",
 * "name": "Баланчировка",
 * "sku": null,
 * "cost_price": {
 * "currency": {
 * "value": 0,
 * "symbol": "руб.",
 * "text": "0,00 руб.",
 * "no_style": "0,00",
 * "rule": "currency"
 * },
 * "exchange": {
 * "value": 0,
 * "symbol": "коп.",
 * "text": "0 коп.",
 * "no_style": "0",
 * "rule": "exchange"
 * }
 * },
 * "client_price": {
 * "currency": {
 * "value": 150,
 * "symbol": "руб.",
 * "text": "150,00 руб.",
 * "no_style": "150,00",
 * "rule": "currency"
 * },
 * "exchange": {
 * "value": 15000,
 * "symbol": "коп.",
 * "text": "15 000 коп.",
 * "no_style": "15 000",
 * "rule": "exchange"
 * }
 * },
 * "amount": 2
 * }
 * ]
 * }
 * },
 * "meta": {
 * "include": [
 * "client",
 * "creator",
 * "updater",
 * "organization"
 * ]
 * }
 * }
 */
