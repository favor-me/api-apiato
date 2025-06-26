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
 * @apiName             getAllPermissions
 * @api                 {get} /v1/permissions Get All Permission
 *
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated User
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::get('permissions', [Controller::class, 'getAllPermissions'])
    ->name('api_authorization_get_all_permissions')
    ->middleware(['auth:api']);
