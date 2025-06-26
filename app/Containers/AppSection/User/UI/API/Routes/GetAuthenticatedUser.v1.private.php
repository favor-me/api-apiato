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
 * @apiName             getAuthenticatedUser
 *
 * @api                 {get} /v1/user/profile Даныне профиля
 * @apiDescription      Получение данных аутентифицированного пользователя с помощью токена.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный пользователь
 *
 * @apiUse              UserSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\Controller;

Route::get('user/profile', [Controller::class, 'getAuthenticatedUser'])
    ->name('api_user_get_authenticated_user')
    ->middleware(['auth:api']);
