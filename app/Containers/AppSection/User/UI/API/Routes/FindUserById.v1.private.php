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
 * @apiGroup            User
 * @apiName             findUserById
 * @api                 {get} /v1/users/:id Найти по ID
 * @apiDescription      Найти пользователя по его id.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный пользователь с правами "search-users"
 *
 * @apiUse              UserSuccessSingleResponse
 *
 * @apiParam            {String} id Уникальный идентификатор пользователя.
 */

use App\Containers\AppSection\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('users/{id}', [Controller::class, 'findUserById'])
    ->name('api_user_find_user')
    ->middleware(['auth:api']);
