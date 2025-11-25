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
 * @apiName createOrganizationUnitPrice

 * @api {post} /v1/organization/unit-prices Создать
 * @apiDescription Создание.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {String} [model]
 * @apiBody {String} [model_id]
 * @apiBody {String} [unit_id]
 * @apiBody {String} [cost_price]
 * @apiBody {String} [price_up] Наценка.
 * @apiBody {String} [client_price]
 *
 * @apiUse UnitPriceSuccessSingleResponse
 */

use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers\CreateUnitPriceController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateUnitPriceController::class)
    ->name('api_organization_unit_price_create_unit_price')
    ->middleware(['auth:api']);
