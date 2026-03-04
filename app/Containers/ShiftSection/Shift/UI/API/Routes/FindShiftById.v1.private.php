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
 * @apiName findByIdOrganizationShift
 * @api {get} /v1/shifts/:id Найти по id
 * @apiDescription Найти по id.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор.
 *
 * @apiUse ShiftSuccessSingleResponse
 */

use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\UI\API\Controllers\FindShiftByIdController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri('{' . ID . '}'), FindShiftByIdController::class)
    ->name('api_organization_shift_find_by_id_shift')
    ->middleware(['auth:api']);
