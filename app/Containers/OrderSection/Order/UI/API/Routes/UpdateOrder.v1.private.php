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
 * @apiName updateOrderOrder
 *
 * @api {post} /v1/order/orders/:id Изменить
 * @apiDescription Изменить. Внимание!!! Завершенные или отмененные заказы невозможно обновлять.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор
 *
 * @apiBody {String} [payment_type] Тип оплаты (см. <a href="#api-OrderPaymentType-getAllOrderPaymentTypes">типы оплат</a>)
 * @apiBody {String} [total] Итоговая цена
 * @apiBody {String} [comment] Комментарий
 * @apiBody {String} [client_id] Уникальный идентификатор клиента
 * @apiBody {String} [status_id] Уникальный идентификатор статуса
 *
 * @apiUse OrderSuccessSingleResponse
 *
 * @apiParamExample {json} Пример для items:
{
    "items": [
        {
            "id": "aYOxlpzRMwrX3gD7", // Уникальный идентификатор order item
            "name": "Item unit name", // Название unit в заказе
            "unit_id": "aYOxlpzRMwrX3gD7", // Уникальный идентификатор unit
            "type": "service", // Тип unit
            "sku": "rt-13", // Артикул unit
            "cost_price": "150", // Себестоимость unit
            "client_price": "200", // Цена для клиента unit
            "amount": 2 // Количество в заказе
        }
    ]
}
 */

use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\UI\API\Controllers\UpdateOrderController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateOrderController::class)
    ->name('api_order_order_update_order')
    ->middleware(['auth:api']);
