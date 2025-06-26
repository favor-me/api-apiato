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
 * @apiName             getAllRoles
 * @api                 {get} /v1/roles Get All Roles
 *
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated User
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::get('roles', [Controller::class, 'getAllRoles'])
    ->name('api_authorization_get_all_roles')
    ->middleware(['auth:api']);
