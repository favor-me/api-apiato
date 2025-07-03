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
 * @apiGroup CommunityOrganizationBranch
 * @apiName getAllCommunityOrganizationBranch
 * @api {get} /v1/community/organization-branches Список
 * @apiDescription Получить список. Для получения отделений организации воспользуйтесь поиском по полю `organization_id`
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String="1,0"} [only-trashed] Вкл.\Откл.показ корзины.
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
 */

use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Controllers\GetAllOrganizationBranchesController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllOrganizationBranchesController::class)
    ->name('api_community_organization_branch_get_all_organization_branch')
    ->middleware(['auth:api']);
