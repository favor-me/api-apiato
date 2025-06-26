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
 * @apiGroup CommunityOrganization
 * @apiName findByIdCommunityOrganization

 * @api {get} /v1/community/organizations/:id Найти по id
 * @apiDescription Найти по id.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор.
 *
 * @apiUse OrganizationSuccessSingleResponse
 */

use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\UI\API\Controllers\FindOrganizationByIdController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri('{' . ID . '}'), FindOrganizationByIdController::class)
    ->name('api_community_organization_find_by_id_organization')
    ->middleware(['auth:api']);
