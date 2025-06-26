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
 * @apiName             revokeRoleFromUser
 * @api                 {post} /v1/roles/revoke Revoke/Remove Roles from User
 * @apiDescription      Revoke existing roles from user. This endpoint does not sync the user
 *                      It just revoke the passed role from the user. So make sure
 *                      to never send a non assigned role since it will cause an error.
 *                      To sync (update) all existing roles with the new ones use
 *                      `/roles/sync` endpoint instead.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated User
 *
 * @apiBody             {Number} user_id user ID
 * @apiBody             {Array} roles_ids Role ID or Array of Role ID's
 *
 * @apiUse              UserSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::post('roles/revoke', [Controller::class, 'revokeRoleFromUser'])
    ->name('api_authorization_revoke_role_from_user')
    ->middleware(['auth:api']);
