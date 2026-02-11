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
 * @api {delete} /v1/organization/shifts Архивировать|Удалить
 * @apiDescription Архивировать или удалить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {Array} ids Список id
 * @apiBody {String="1"} [force-delete] Произвести жёсткое удаление (удаляется запись из базы).
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
 */

use App\Containers\OrganizationSection\Shift\Facades\Container;
use App\Containers\OrganizationSection\Shift\UI\API\Controllers\DeleteShiftsController;
use App\Containers\OrganizationSection\Shift\UI\API\Controllers\TrashShiftsController;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Facades\Route;

Route::delete(Container::getApiUri(), function (ApiRequest $request) {
    $callback = $request->isForceDelete() ?
        DeleteShiftsController::class : TrashShiftsController::class;
    return app()->call($callback);
})
    ->name('api_organization_shift_trash_or_delete_shifts')
    ->middleware(['auth:api']);
