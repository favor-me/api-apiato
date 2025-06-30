<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 *
 * @apiGroup CommunityOrganization
 * @apiName updateOwnCommunityOrganization

 * @api {patch} /v1/community/organizations/own Изменить свою
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь (Собственник организации)
 *
 * @apiBody {String} [name] Название организации.
 * @apiBody {String} [inn] ИНН.
 * @apiBody {String} [phone_number] Контактный номер телефона.
 * @apiBody {String} [email] Контактный адрес электронной почты.
 *
 * @apiUse OrganizationSuccessSingleResponse
 */

use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\UI\API\Controllers\UpdateOwnOrganizationController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('own'), UpdateOwnOrganizationController::class)
    ->name('api_community_organization_update_own_organization')
    ->middleware(['auth:api']);
