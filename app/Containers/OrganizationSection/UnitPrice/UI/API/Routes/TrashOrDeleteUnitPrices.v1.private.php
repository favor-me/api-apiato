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
 * @apiGroup OrganizationUnitPrice
 * @apiName trashOrDeleteOrganizationUnitPrices

 * @api {delete} /v1/organization/unit-prices Архивировать|Удалить
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

use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers\DeleteUnitPricesController;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers\TrashUnitPricesController;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Facades\Route;

Route::delete(Container::getApiUri(), function (ApiRequest $request) {
    $callback = $request->isForceDelete() ?
        DeleteUnitPricesController::class : TrashUnitPricesController::class;
    return app()->call($callback);
})
    ->name('api_organization_unit_price_trash_or_delete_unit_prices')
    ->middleware(['auth:api']);
