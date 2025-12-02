<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 *
 * @apiGroup OrderPaymentType
 * @apiName getAllOrderPaymentTypes
 *
 * @api {get} /v1/order/payment-types Список
 * @apiDescription Получить список доступных типов оплатов.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "data": [
        {
            "name": "cash",
            "title": "Наличные"
        },
        {
            "name": "cashless",
            "title": "Безналичный расчёт"
        }
    ],
    "meta": {
        "include": []
    }
}
 * @apiSuccessExample {json} Успешный ответ списка to=list:
HTTP/1.1 200 OK
{
    "data": [
        {
            "value": "cash",
            "title": "Наличные"
        },
        {
            "value": "cashless",
            "title": "Безналичный расчёт"
        }
    ],
    "meta": {
        "include": []
    }
}
 */

use App\Containers\OrderSection\PaymentType\Facades\Container;
use App\Containers\OrderSection\PaymentType\UI\API\Controllers\GetAllPaymentTypesController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllPaymentTypesController::class)
    ->name('api_order_payment_types_get_all')
    ->middleware(['auth:api']);
