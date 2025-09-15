<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 *
 * @apiGroup CommunityOrganizationUnit
 * @apiName updateCommunityOrganizationUnit
 * @api {post} /v1/community/organization-units/:id Изменить
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiParam {String} id Уникальный идентификатор
 *
 * @apiBody {String} [name] Название
 * @apiBody {String} [type] Тип (имя `name` типа) (см. <a href="#api-CommunityOrganizationUnitType-getAllCommunityOrganizationUnitTypes">типы</a>)
 * @apiBody {String|Null} [sku] Артикул
 * @apiBody {Numeric} [ordering] Значение сортировки
 * @apiBody {Array|Object} [params] Дополнительные параметры
 * @apiBody {Numeric} [cost_price] Себестоимость
 * @apiBody {Numeric} [price_up] Наценка себестоимости в % для расчёта цены продажи
 * @apiBody {Numeric} [client_price] Цена продажи
 * @apiBody {Numeric} [balance] Остаток
 * @apiBody {Boolean=0,1} [is_infinity_balance] Флаг бесконечного остатка
 * @apiBody {String} [organization_id] Уникальный идентификатор органзации. Устанавливается автоматически.
 * @apiBody {String} [system_unit_id] Уникальный идентификатор еденицы измерения
 *
 * @apiUse OrganizationUnitSuccessSingleResponse
 */

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers\UpdateOrganizationUnitController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateOrganizationUnitController::class)
    ->name('api_community_organization_unit_update_organization_unit')
    ->middleware(['auth:api']);
