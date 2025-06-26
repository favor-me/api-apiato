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
 * @apiName             syncUserRoles
 * @api                 {post} /v1/roles/sync Sync User Roles
 * @apiDescription      You can use this endpoint instead of `roles/assign` & `roles/revoke`.
 *                      The sync endpoint will override all existing user roles with the new
 *                      one sent to this endpoint.
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

Route::post('roles/sync', [Controller::class, 'syncUserRoles'])
    ->name('api_authorization_sync_user_roles')
    ->middleware(['auth:api']);
