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
 * @apiName createCommunityOrganizationBranch
 * @api {post} /v1/community/organization-branches Создать
 * @apiDescription Создание.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {String} name Название отделения.
 * @apiBody {String} phone_number Контактный номер.
 * @apiBody {String} location Расположение\Адрес
 * @apiBody {String} latitude Широта (координаты). Значения между `-90,90`
 * @apiBody {String} longitude Долгота (координаты). Значения между `-180,180`
 * @apiBody {String} [coordinates] Координаты в формате `40.317871093749986, 51.69050011510639`
 * @apiBody {String} [responsible_by] Ответственный пользователь за отделение. По умолчанию устанавливается собственник.
 *
 * @apiUse OrganizationBranchSuccessSingleResponse
 */

use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Controllers\CreateOrganizationBranchController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateOrganizationBranchController::class)
    ->name('api_community_organization_branch_create_organization_branch')
    ->middleware(['auth:api']);
