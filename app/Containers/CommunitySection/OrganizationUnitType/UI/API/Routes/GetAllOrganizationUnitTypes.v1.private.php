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
 * @apiGroup CommunityOrganizationUnitType
 * @apiName getAllCommunityOrganizationUnitTypes
 * @api {get} /v1/community/organization-unit-types Список
 * @apiDescription Получить список доступных типов.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
* {
    * "data": [
        * {
            * "name": "product",
            * "title": "Продукт"
        * },
        * {
            * "name": "service",
            * "title": "Услуга"
 * }
 * ],
 * "meta": {
 * "include": []
 * }
 * }
 * @apiSuccessExample {json} Успешный ответ списка to=list:
 * HTTP/1.1 200 OK
 * {
 * "data": [
 * {
 * "value": "product",
 * "title": "Продукт"
 * },
 * {
 * "value": "service",
 * "title": "Услуга"
 * }
 * ],
    * "meta": {
        * "include": []
    * }
* }
 */

use App\Containers\CommunitySection\OrganizationUnitType\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnitType\UI\API\Controllers\GetAllOrganizationUnitTypesController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllOrganizationUnitTypesController::class)
    ->name('api_community_organization_unit_types_get_all')
    ->middleware(['auth:api']);
