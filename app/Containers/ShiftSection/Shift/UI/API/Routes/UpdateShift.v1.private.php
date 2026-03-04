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
 * @apiGroup Shift
 * @apiName updateShift
 * @api {patch} /v1/shifts/:id Изменить
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiParam {String} id Уникальный идентификатор
 *
 * @apiBody {String} [start_at] Дата начала.
 * @apiBody {String} [finish_at] Дата завершения.
 * @apiBody {Int} [confirmed=1,0] Установить подтверждение смены (`created_at` установится автоматически).
 * @apiBody {Int} [payment=1,0] Установить дату и время оплаты за смену.
 *
 * @apiUse ShiftSuccessSingleResponse
 */

use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\UI\API\Controllers\UpdateShiftController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateShiftController::class)
    ->name('api_organization_shift_update_shift')
    ->middleware(['auth:api']);
