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
 * @apiName createCommunityOrganization

 * @api {post} /v1/community/organizations Создать
 * @apiDescription Создание.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
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
use App\Containers\CommunitySection\Organization\UI\API\Controllers\CreateOrganizationController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateOrganizationController::class)
    ->name('api_community_organization_create_organization')
    ->middleware(['auth:api']);
