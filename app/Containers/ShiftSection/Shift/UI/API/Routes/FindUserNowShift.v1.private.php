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
 * @apiName findUserNowShift
 * @api {get} /v1/shifts/now Найти текущую смену
 * @apiDescription Найти текущую смену пользователя
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiUse ShiftSuccessSingleResponse
 */

use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\UI\API\Controllers\FindUserNowShiftController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri('now'), FindUserNowShiftController::class)
    ->name('api_organization_shift_find_user_now_shift')
    ->middleware(['auth:api']);
