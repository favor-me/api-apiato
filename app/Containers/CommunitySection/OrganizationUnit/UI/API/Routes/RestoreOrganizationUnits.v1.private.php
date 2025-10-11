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
 * @apiName restoreCommunityOrganizationUnit
 * @api {post} /v1/restore/community/organization-units Восстановить
 * @apiDescription Восстановление одной или несколько записей. Перемещение из корзины в "рабочую зону"..
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiBody {Array} ids Id массив элементов
 *
 * @apiParamExample {json} Пример формирования ids:
 * "ids": [
 * "NxOpZowo9GmjKqdR",
 * "XbPW7awNkzl83LD6",
 * "KJqn4Z26Owdlv6MB"
 * ]
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 202 Accepted
 * {
 * "message": "Успешно восстановлены 3 элемента."
 * }
 */

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers\RestoreOrganizationUnitsController;
use Illuminate\Support\Facades\Route;

Route::post('restore/' . Container::getApiUri(), RestoreOrganizationUnitsController::class)
    ->name('api_community_organization_unit_restore_organization_unit')
    ->middleware(['auth:api']);
