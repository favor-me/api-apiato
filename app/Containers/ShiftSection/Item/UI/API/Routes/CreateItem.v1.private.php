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
 * @apiName createShiftItem
 * @api {post} /v1/shift/items Создать
 * @apiDescription Создание позиции для смены.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiBody {String} shift_id Уникальный идентификатор смены.
 * @apiBody {String} type Тип позиции (см. <a href="##api-ShiftItem-getAllShiftItemTypes">тут</a>)
 * @apiBody {String} [order_id] Уникальный идентификатор заказа.
 * @apiBody {String} [value=0] Денежное значение.
 * @apiBody {String} [description] Описание.
 *
 * @apiUse ItemSuccessSingleResponse
 */

use App\Containers\ShiftSection\Item\Facades\Container;
use App\Containers\ShiftSection\Item\UI\API\Controllers\CreateItemController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateItemController::class)
    ->name('api_shift_item_create_item')
    ->middleware(['auth:api']);
