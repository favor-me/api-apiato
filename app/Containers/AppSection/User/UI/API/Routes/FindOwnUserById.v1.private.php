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
 * @apiGroup User
 * @apiName findOwnUserById
 * @api {get} /v1/own/users/:id Найти своего по ID
 * @apiDescription Найти своего пользователя по его id.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью "organization_owner"
 *
 * @apiUse UserSuccessSingleResponse
 *
 * @apiParam {String} id Уникальный идентификатор пользователя.
 */

use App\Containers\AppSection\User\UI\API\Controllers\FindOwnUserByIdController;
use Illuminate\Support\Facades\Route;

Route::get('own/users/{' . ID . '}', FindOwnUserByIdController::class)
    ->name('api_user_find_own_user')
    ->middleware(['auth:api']);
