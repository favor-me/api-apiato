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
 * @apiName             assignUserToRole
 * @api                 {post} /v1/roles/assign Assign User to Roles
 * @apiDescription      Assign new roles to user. This endpoint does not sync the user with the
 *                      new roles. It simply assign new role to the user. So make sure
 *                      to never send an already assigned role since it will cause an error.
 *                      To sync (update) all existing roles with the new ones use
 *                      `/roles/sync` endpoint instead.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated User
 *
 * @apiBody             {Number} user_id User ID
 * @apiBody             {Array} roles_ids Role ID or Array of Roles ID's
 *
 * @apiUse              UserSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::post('roles/assign', [Controller::class, 'assignUserToRole'])
    ->name('api_authorization_assign_user_to_role')
    ->middleware(['auth:api']);
