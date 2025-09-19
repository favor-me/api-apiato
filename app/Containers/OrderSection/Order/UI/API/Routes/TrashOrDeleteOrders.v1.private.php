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
 * @apiGroup Order
 * @apiName trashOrDeleteOrderOrders
 * @api {delete} /v1/order/orders Архивировать|Удалить
 * @apiDescription Архивировать или удалить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {Array} ids Список id
 * @apiBody {String="1"} [force-delete] Произвести жёсткое удаление (удаляется запись из базы).
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
 */

use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\UI\API\Controllers\DeleteOrdersController;
use App\Containers\OrderSection\Order\UI\API\Controllers\TrashOrdersController;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Facades\Route;

Route::delete(Container::getApiUri(), function (ApiRequest $request) {
    $callback = $request->isForceDelete() ?
        DeleteOrdersController::class : TrashOrdersController::class;
    return app()->call($callback);
})
    ->name('api_order_order_trash_or_delete_orders')
    ->middleware(['auth:api']);
