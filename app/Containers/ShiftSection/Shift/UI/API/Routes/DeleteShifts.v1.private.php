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
 * @apiGroup OrganizationShift
 * @apiName trashOrDeleteOrganizationShifts
 * @api {delete} /v1/shifts Удалить
 * @apiDescription Удалить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiBody {Array} ids Список id
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
 */

use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\UI\API\Controllers\DeleteShiftsController;
use Illuminate\Support\Facades\Route;

Route::delete(Container::getApiUri(), DeleteShiftsController::class)
    ->name('api_organization_shift_trash_shifts')
    ->middleware(['auth:api']);
