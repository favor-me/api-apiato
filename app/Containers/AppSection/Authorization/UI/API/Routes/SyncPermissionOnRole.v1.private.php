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
 * @apiName             syncPermissionOnRole
 * @api                 {post} /v1/permissions/sync Sync Permissions on Role
 * @apiDescription      You can use this endpoint instead of `permissions/attach` & `permissions/detach`.
 *                      The sync endpoint will override all existing role permissions with the new
 *                      one sent to this endpoint.
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated User
 *
 * @apiBody             {String} role_id Role ID
 * @apiBody             {Array} permissions_ids Permission ID or Array of Permissions ID's
 *
 * @apiUse              RoleSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::post('permissions/sync', [Controller::class, 'syncPermissionOnRole'])
    ->name('api_authorization_sync_permission_on_role')
    ->middleware(['auth:api']);
