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
 * @apiName getAllCommunityOrganizationUnit
 *
 * @api {get} /v1/community/organization-units Список
 * @apiDescription Получить список.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролями `organization_owner`, `organization_worker`
 *
 * @apiParam {String="1,0"} [only-trashed] Вкл.\Откл.показ корзины. Корзина доступна только пользователю с ролью `organization_owner`
 * @apiParam {String} [price_from] Подключить цены из контекста. Для использования model:model_id. Пример для договора `price_from=contract:Yx9DE6y7PN2XqbWv`
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
 */

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers\GetAllOrganizationUnitsController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllOrganizationUnitsController::class)
    ->name('api_community_organization_unit_get_all_organization_unit')
    ->middleware(['auth:api']);
