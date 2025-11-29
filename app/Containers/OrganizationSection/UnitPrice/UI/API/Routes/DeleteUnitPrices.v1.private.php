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

 * @api {delete} /v1/organization/unit-prices/:model/:model_id Удалить
 * @apiDescription Удалить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiParam {String=contract} model Тип модели (сущность к которой привязывается цена)
 * @apiParam {String} model_id Уникальный идентификатор сущности
 *
 * @apiBody {Array} unit_ids Список id услуг или товаров
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
 */

use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers\DeleteUnitPricesController;
use Illuminate\Support\Facades\Route;

Route::delete(Container::getApiUri('{' . UnitPrice::MODEL_ID . '}'), DeleteUnitPricesController::class)
    ->name('api_organization_unit_price_delete_unit_prices')
    ->middleware(['auth:api']);
