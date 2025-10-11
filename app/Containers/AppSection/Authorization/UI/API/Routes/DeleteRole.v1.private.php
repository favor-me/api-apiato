<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 *
 * @apiGroup            RolePermission
 * @apiName             deleteRole
 * @api                 {delete} /v1/roles/:id Delete a Role
 * @apiDescription      Delete Role by ID
 *
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated Role
 *
 * @apiParam            {String} id Уникальный идентификатор роли.
 *
 * @apiSuccessExample  {json}       Success-Response:
HTTP/1.1 202 OK
{
    "message": "Role (manager) Deleted Successfully."
}
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::delete('roles/{id}', [Controller::class, 'deleteRole'])
    ->name('api_authorization_delete_role')
    ->middleware(['auth:api']);
