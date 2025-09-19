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
 * @apiGroup OrderItem
 * @apiName trashOrDeleteOrderItems
 * @api {delete} /v1/order/items/:order_id Удалить
 * @apiDescription Удалить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} order_id Уникальный идентификатор заказа
 * @apiBody {Array} ids Список id
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
 */

use App\Containers\OrderSection\Item\Facades\Container;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\UI\API\Controllers\DeleteItemsController;
use Illuminate\Support\Facades\Route;

Route::delete(Container::getApiUri('{' . Item::ORDER_ID . '}'), DeleteItemsController::class)
    ->name('api_order_item_delete_items')
    ->middleware(['auth:api']);
