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
 * @_apiGroup CommunityOrganization
 * @apiName getAllCommunityOrganization

 * @api {get} /v1/community/organizations Список
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

use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\UI\API\Controllers\GetAllOrganizationsController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllOrganizationsController::class)
    ->name('api_community_organization_get_all_organization')
    ->middleware(['auth:api']);
