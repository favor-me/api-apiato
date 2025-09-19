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
 * @apiName findByIdOrderOrder
 * @api {get} /v1/order/orders/:id Найти по id
 * @apiDescription Найти по id.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор.
 *
 * @apiUse OrderSuccessSingleResponse
 */

use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\UI\API\Controllers\FindOrderByIdController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri('{' . ID . '}'), FindOrderByIdController::class)
    ->name('api_order_order_find_by_id_order')
    ->middleware(['auth:api']);
