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
 * @apiGroup OrganizationOwnershipType
 * @apiName getAllOrganizationOwnershipType
 *
 * @api {get} /v1/organization/ownership-types Список
 * @apiDescription Список типов собственности организации.
 *
 * @apiVersion 1.0.0
 * @apiPermission ПубличноУП
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
{
    "data": [
        {
            "title": "Индивидуальный предприниматель",
            "name": "ip"
        }
    ],
    "meta": {
        "include": []
    }
}
 */


use App\Containers\OrganizationSection\OwnershipType\Facades\Container;
use App\Containers\OrganizationSection\OwnershipType\UI\API\Controllers\GetAllOwnershipTypesController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllOwnershipTypesController::class)
    ->name('api_organization_ownership_types_create_ownership_types');
