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
 * @codingStandardsIgnoreStart
 *
 * @apiGroup CommunityOrganizationUnit
 * @apiName findByIdCommunityOrganizationUnit
 *
 * @api {get} /v1/community/organization-units/:id Найти по id
 * @apiDescription Найти по id.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролями `organization_owner`, `organization_worker`
 *
 * @apiParam {String} id Уникальный идентификатор.
 * @apiParam {String} [price_from] Подключить цены из контекста. Для использования model:model_id. Пример для договора `price_from=contract:Yx9DE6y7PN2XqbWv`
 *
 * @apiUse OrganizationUnitSuccessSingleResponse
 */

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers\FindOrganizationUnitByIdController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri('{' . ID . '}'), FindOrganizationUnitByIdController::class)
    ->name('api_community_organization_unit_find_by_id_organization_unit')
    ->middleware(['auth:api']);
