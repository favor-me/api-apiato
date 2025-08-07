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
 * @apiName getAllCommunityOrganizationUnit

 * @api {get} /v1/community/organization-units Список
 * @apiDescription Получить список.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String="1,0"} [only-trashed] Вкл.\Откл.показ корзины.
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
 */

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers\GetAllOrganizationUnitsController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllOrganizationUnitsController::class)
    ->name('api_community_organization_unit_get_all_organization_unit')
    ->middleware(['auth:api']);
