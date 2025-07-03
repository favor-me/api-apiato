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
 * @apiName trashOrDeleteCommunityOrganizationBranches
 * @api {delete} /v1/community/organization-branches Архивировать|Удалить
 * @apiDescription Архивировать (для собственника) или удалить (для администратора).
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {Array} ids Список id
 * @apiBody {String="1"} [force-delete] Произвести жёсткое удаление (удаляется запись из базы).
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
 */

use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Controllers\DeleteOrganizationBranchesController;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Controllers\TrashOrganizationBranchesController;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Facades\Route;

Route::delete(Container::getApiUri(), function (ApiRequest $request) {
    $callback = $request->isForceDelete() ?
        DeleteOrganizationBranchesController::class : TrashOrganizationBranchesController::class;
    return app()->call($callback);
})
    ->name('api_community_organization_branch_trash_or_delete_organization_branches')
    ->middleware(['auth:api']);
