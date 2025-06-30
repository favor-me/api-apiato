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
 * @apiName updateCommunityOrganization

 * @api {patch} /v1/community/organizations/:id Изменить
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор
 *
 * @apiBody {String} [name]
 * @apiBody {String} [inn]
 * @apiBody {String} [phone_number]
 * @apiBody {String} [email]
 * @apiBody {String} [params]
 *
 * @apiUse OrganizationSuccessSingleResponse
 */

use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\UI\API\Controllers\UpdateOrganizationController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateOrganizationController::class)
    ->name('api_community_organization_update_organization')
    ->where(ID, '^(?!own$).+')
    ->middleware(['auth:api']);
