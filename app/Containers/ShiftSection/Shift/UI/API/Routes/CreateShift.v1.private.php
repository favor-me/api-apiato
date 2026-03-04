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
 * @apiName createShift
 * @api {post} /v1/shifts Создать
 * @apiDescription Создание.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {String} start_at Дата начала.
 * @apiBody {String} finish_at Дата завершения.
 * @apiBody {Boolean=false,true} [exclude_organization_branch] Если передать `true` отделение не будет связано со сменой.
 *
 * @apiUse ShiftSuccessSingleResponse
 */

use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\UI\API\Controllers\CreateShiftController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateShiftController::class)
    ->name('api_organization_shift_create_shift')
    ->middleware(['auth:api']);
