<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 *
 * @apiGroup ModelEvent
 * @apiName getAllModelEventTypes
 *
 * @api {get} /v1/model-events/types/all Список событий
 * @apiDescription Список всех доступных типов событий.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "data": [
        {
            "title": "Заказ создан",
            "value": "created_order"
        },
        {
            "title": "Заказ восстановлен из архива",
            "value": "restored_order"
        },
        {
            "title": "Заказ перемещён в архив",
            "value": "trashed_order"
        }
    ],
    "meta": {
        "include": [],
        "custom": []
    }
}
 */

use App\Containers\HistorySection\ModelEvent\Facades\Container;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelEvent\UI\API\Controllers\GetAllModelEventTypesController;
use Illuminate\Support\Facades\Route;

$uri = Container::getApiUri(BaseModelEvent::API_URI_ALL_TYPES);

Route::get($uri, GetAllModelEventTypesController::class)
    ->name('api_model_events_get_all_model_event_types')
    ->middleware(['auth:api']);
