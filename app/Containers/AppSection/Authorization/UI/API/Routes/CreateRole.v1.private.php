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
 * @apiName             createRole
 * @api                 {post} /v1/roles Create a Role
 *
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated User
 *
 * @apiBody             {String} name Unique Role Name
 * @apiBody             {String} [description]
 * @apiBody             {String} [display_name]
 *
 * @apiUse              RoleSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::post('roles', [Controller::class, 'createRole'])
    ->name('api_authorization_create_role')
    ->middleware(['auth:api']);
