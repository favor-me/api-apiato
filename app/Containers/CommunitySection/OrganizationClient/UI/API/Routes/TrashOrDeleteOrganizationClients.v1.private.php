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
 * @apiGroup CommunityOrganizationClient
 * @apiName trashOrDeleteCommunityOrganizationClients
 * @api {delete} /v1/community/organization-clients Архивировать|Удалить
 * @apiDescription Архивировать или удалить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь  с правами "organization_owner"
 *
 * @apiBody {Array} ids Список id
 * @apiBody {String="1"} [force-delete] Произвести жёсткое удаление (удаляется запись из базы).
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "message": "Успешно перемещен в корзину 1 клиент."
}
 */

use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Controllers\DeleteOrganizationClientsController;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Controllers\TrashOrganizationClientsController;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Facades\Route;

Route::delete(Container::getApiUri(), function (ApiRequest $request) {
    $callback = $request->isForceDelete() ?
        DeleteOrganizationClientsController::class : TrashOrganizationClientsController::class;
    return app()->call($callback);
})
    ->name('api_community_organization_client_trash_or_delete_organization_clients')
    ->middleware(['auth:api']);
