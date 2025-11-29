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

 * @api {post} /v1/organization/unit-prices/:model Создать
 * @apiDescription Создание цены.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiParam {String=contract} model Тип модели (сущность к которой привязывается цена)
 *
 * @apiBody {String} model_id Уникальный идентификатор сущности типа модели.
 * @apiBody {String} unit_id Уникальный идентификатор товара или услуги.
 * @apiBody {Numeric} cost_price Себестоимость.
 * @apiBody {Numeric} price_up Наценка себестоимости в % для расчёта цены продажи.
 * @apiBody {Numeric} client_price Цена продажи.
 *
 * @apiUse OrganizationUnitSuccessSingleResponse
 */

use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers\CreateUnitPriceController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateUnitPriceController::class)
    ->name('api_organization_unit_price_create_unit_price')
    ->middleware(['auth:api']);
