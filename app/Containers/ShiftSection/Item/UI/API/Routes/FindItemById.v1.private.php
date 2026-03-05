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
 * @apiName findByIdShiftItem
 * @api {get} /v1/shift/items/:id Найти по id
 * @apiDescription Найти по id.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiParam {String} id Уникальный идентификатор.
 *
 * @apiUse ItemSuccessSingleResponse
 */

use App\Containers\ShiftSection\Item\Facades\Container;
use App\Containers\ShiftSection\Item\UI\API\Controllers\FindItemByIdController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri('{' . ID . '}'), FindItemByIdController::class)
    ->name('api_shift_item_find_by_id_item')
    ->middleware(['auth:api']);
