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
 * @apiGroup ShiftItem
 * @apiName getAllShiftItemTypes
 *
 * @api {get} /v1/shift/item-types Список типов
 * @apiDescription Список типов.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
{
    "data": [
        {
            "title": "Премия",
            "name": "award"
        },
        {
            "title": "Штраф",
            "name": "fine"
        },
        {
            "title": "Заработок",
            "name": "income"
        },
    ],
    "meta": {
        "include": []
    }
}
 */

use App\Containers\ShiftSection\ItemType\Facades\Container;
use App\Containers\ShiftSection\ItemType\UI\API\Controllers\GetAllItemTypesController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllItemTypesController::class)
    ->name('api_shift_item_types_get_all_item_types');
