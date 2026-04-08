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
 * @apiGroup Shift
 * @apiName confirmShifts
 * @api {patch} /v1/shifts/paid Оплатить
 * @apiDescription Оплатить смены.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiBody {Array} ids Список уникальных идентификаторов смены.
 *
 * @apiUse ShiftSuccessSingleResponse
 */

use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\UI\API\Controllers\PaidShiftsController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('paid'), PaidShiftsController::class)
    ->name('api_organization_shift_paid_shifts')
    ->middleware(['auth:api']);
