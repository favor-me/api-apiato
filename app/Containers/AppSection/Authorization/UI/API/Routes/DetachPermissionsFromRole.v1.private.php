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
 * @apiName             detachPermissionFromRole
 * @api                 {post} /v1/permissions/detach Detach Permissions from Role
 * @apiDescription      Detach existing permission from role. This endpoint does not sync the role
 *                      It just detach the passed permissions from the role. So make sure
 *                      to never send an non attached permission since it will cause an error.
 *                      To sync (update) all existing permissions with the new ones use
 *                      `/permissions/sync` endpoint instead.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated User
 *
 * @apiBody             {String} role_id Role ID
 * @apiBody             {String-Array} permissions_ids Permission ID or Array of Permissions ID's
 *
 * @apiUse              RoleSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::post('permissions/detach', [Controller::class, 'detachPermissionFromRole'])
    ->name('api_authorization_detach_permission_from_role')
    ->middleware(['auth:api']);
