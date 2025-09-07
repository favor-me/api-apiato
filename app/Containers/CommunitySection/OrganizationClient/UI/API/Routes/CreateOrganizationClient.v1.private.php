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
 * @apiName createCommunityOrganizationClient
 * @api {post} /v1/community/organization-clients Создать
 * @apiDescription Создание.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {String} name Имя
 * @apiBody {String} [patronymic] Отчество
 * @apiBody {String} [surname] Фамилия
 * @apiBody {String} [phone_number] Контактный номер телефона
 * @apiBody {String} [note] Заметка
 *
 * @apiUse OrganizationClientSuccessSingleResponse
 */

use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Controllers\CreateOrganizationClientController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateOrganizationClientController::class)
    ->name('api_community_organization_client_create_organization_client')
    ->middleware(['auth:api']);
