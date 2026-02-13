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
 * @apiDefine ShiftSuccessSingleResponse
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "data": {
        "object": "Shift",
        "id": null,
        "organization_id": null,
        "organization_branch_id": null,
        "start_at": null,
        "finish_at": null,
        "created_by": null,
        "created_at": null,
        "updated_at": null
    },
    "meta": {
        "include": [
            "creator",
            "organization",
            "organization_branch"
        ]
    }
}
 */
