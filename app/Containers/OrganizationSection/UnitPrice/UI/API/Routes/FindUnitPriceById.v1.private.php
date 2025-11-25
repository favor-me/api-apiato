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
 * @apiName findByIdOrganizationUnitPrice

 * @api {get} /v1/organization/unit-prices/:id Найти по id
 * @apiDescription Найти по id.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор.
 *
 * @apiUse UnitPriceSuccessSingleResponse
 */

use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers\FindUnitPriceByIdController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri('{' . ID . '}'), FindUnitPriceByIdController::class)
    ->name('api_organization_unit_price_find_by_id_unit_price')
    ->middleware(['auth:api']);
