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
 * @apiName updateCommunityOrganizationClient
 * @api {post} /v1/community/organization-clients/:id Изменить
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор
 *
 * @apiBody {String} [name] Имя
 * @apiBody {String} [patronymic] Отчество
 * @apiBody {String} [surname] Фамилия
 * @apiBody {String} [phone_number] Контактный номер телефона
 * @apiBody {String} [note] Заметка
 *
 * @apiUse OrganizationClientSuccessSingleResponse
 */

use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Controllers\UpdateOrganizationClientController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateOrganizationClientController::class)
    ->name('api_community_organization_client_update_organization_client')
    ->middleware(['auth:api']);
