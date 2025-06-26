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
 *
 * @apiDefine UserSuccessSingleResponse
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "data": {
        "object": "User",
        "id": "XbPW7awNkzl83LD6",
        "name": "Иванов",
        "patronymic": "Иван",
        "surname": "Иванович",
        "gender": true,
        "birth": 642801600,
        "avatar": null,
        "email": "mail@gmail.com",
        "phone_number": null,
        "email_verified_at": null,
        "phone_number_verified_at": null,
        "country_id": "",
        "region_id": "",
        "city_id": "",
        "created_at": 1661435217,
        "updated_at": 1661435217,
        "readable_created_at": "1 секунду назад",
        "readable_updated_at": "1 секунду назад",
        "profile": {
            "data": {
                "object": "Profile",
                "login": "profile-2",
                "about_me": null,
                "address": "Moscow CITY",
                "latitude": null,
                "longitude": null
            }
        }
    },
    "meta": {
        "include": [
            "city",
            "roles",
            "region",
            "profile",
            "country",
            "contact",
            "devices"
        ],
        "custom": []
    }
}
*/
