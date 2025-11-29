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

 * @api {post} /v1/organization/unit-prices/:model/:model_id/:unit_id Изменить
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiParam {String=contract} model Тип модели (сущность к которой привязывается цена)
 * @apiParam {String} model_id Уникальный идентификатор сущности
 * @apiParam {String} unit_id Уникальный идентификатор товара или услуги
 *
 * @apiBody {Numeric} [cost_price] Себестоимость.
 * @apiBody {Numeric} [price_up] Наценка себестоимости в % для расчёта цены продажи.
 * @apiBody {Numeric} [client_price] Цена продажи.
 *
 * @apiUse OrganizationUnitSuccessSingleResponse
 */

use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers\UpdateUnitPriceController;
use Illuminate\Support\Facades\Route;

$uri = Container::getApiUri('{' . UnitPrice::MODEL_ID . '}/{' . UnitPrice::UNIT_ID . '}');

Route::patch($uri, UpdateUnitPriceController::class)
    ->name('api_organization_unit_price_update_unit_price')
    ->middleware(['auth:api']);
