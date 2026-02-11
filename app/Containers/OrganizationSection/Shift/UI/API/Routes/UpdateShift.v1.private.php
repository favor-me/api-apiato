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
 * @apiName updateOrganizationShift
 * @api {patch} /v1/organization/shifts/:id Изменить
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор
 *
 * @apiBody {String} [organization_id] Уникальный идентификатор организации.
 * @apiBody {String} [start_at] Дата начала.
 * @apiBody {String} [finish_at] Дата завершения.
 * @apiBody {String} [created_by]
 *
 * @apiUse ShiftSuccessSingleResponse
 */

use App\Containers\OrganizationSection\Shift\Facades\Container;
use App\Containers\OrganizationSection\Shift\UI\API\Controllers\UpdateShiftController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateShiftController::class)
    ->name('api_organization_shift_update_shift')
    ->middleware(['auth:api']);
