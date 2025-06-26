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
 * @apiName             getPermission
 * @api                 {get} /v1/permissions/:id Find a Permission by ID
 *
 * @apiVersion          1.0.0
 * @apiPermission       Authenticated User
 *
 * @apiParam            {String} id Уникальный идентификатор доступа.
 *
 * @apiUse              PermissionSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller;

Route::get('permissions/{id}', [Controller::class, 'findPermission'])
    ->name('api_authorization_get_permission')
    ->middleware(['auth:api']);
