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
 * @api {patch} /v1/community/organizations/own Изменить свою
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь (Собственник организации)
 *
 * @apiBody {String} [name] Название организации.
 * @apiBody {String=ip,ooo,self_employed} ownership_type Тип собственности.
 * @apiBody {String=ru} [country] Код страны.
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
