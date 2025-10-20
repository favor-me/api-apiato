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
 * @codingStandardsIgnoreStart
 *
 * @apiGroup CommunityOrganizationUnit
 * @apiName plusCommunityOrganizationUnitBalance
 * @api {post} /v1/community/organization-units/:id/plus-balance Добавить баланс
 * @apiDescription Добавить баланс для юнита.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiParam {String} id Уникальный идентификатор
 *
 * @apiBody {Numeric} balance Количество баланса которое нужно добавить
 * @apiBody {Boolean=0,1} [is_infinity_balance] Флаг бесконечного остатка (Если равен `1` тогда `balance` не обязателен)
 *
 * @apiUse OrganizationUnitSuccessSingleResponse
 */

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers\PlusOrganizationUnitBalanceController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}/plus-balance'), PlusOrganizationUnitBalanceController::class)
    ->name('api_community_organization_unit_plus_unit_balance')
    ->middleware(['auth:api']);
