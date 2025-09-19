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
 * @codingStandardsIgnoreStart
 *
 * @apiGroup Order
 * @apiName createOrderOrder
 * @api {post} /v1/order/orders Создать
 * @apiDescription Создание.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {String=cash,cashless} payment_type Тип оплаты (см. <a href="#api-OrderPaymentType-getAllOrderPaymentTypes">типы оплат</a>)
 * @apiBody {String} total Итоговая цена
 * @apiBody {String} comment Комментарий
 * @apiBody {String} client_id Уникальный идентификатор клиента
 *
 * @apiUse OrderSuccessSingleResponse
 */

use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\UI\API\Controllers\CreateOrderController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateOrderController::class)
    ->name('api_order_order_create_order')
    ->middleware(['auth:api']);
