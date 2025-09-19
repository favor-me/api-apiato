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
 * "id": null,
 * "organization_id": null,
 * "oid": null,
 * "payment_type": "cash",
 * "total": null,
 * "comment": "Aliquam et rerum tenetur ut.",
 * "client_id": null,
 * "created_by": null,
 * "updated_by": null,
 * "created_at": null,
 * "updated_at": null,
 * "deleted_at": null
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
