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
 * @apiName updateOrganizationUnitPrice

 * @api {post} /v1/organization/unit-prices/:id Изменить
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор
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
use App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers\UpdateUnitPriceController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateUnitPriceController::class)
    ->name('api_organization_unit_price_update_unit_price')
    ->middleware(['auth:api']);
