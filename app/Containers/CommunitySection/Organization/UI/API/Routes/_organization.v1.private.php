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
 * @apiDefine OrganizationSuccessSingleResponse
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "data": {
        "object": "Organization",
        "id": null,
        "name": "New Organization",
        "phone_number": 79271112233,
        "email": "company@example.com",
        "params": null,
        "country": {
            "title": "Россия",
            "name": "ru"
        },
        "ownership_type": {
            "title": "ИП",
            "name": "ip"
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
        "created_at": null,
        "updated_at": null,
        "deleted_at": null
    },
    "meta": {
        "include": []
    }
}
 */
