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
 * @apiName             getAllUsers
 * @api                 {get} /v1/users Список всех пользователей
 * @apiDescription      Получить всех пользователей приложения (клиентов и администраторов).
 *                      Для всех зарегистрированных пользователей "Клиенты" можно использовать только `/clients`.
 *                      Для всех «Администраторов» дополнительно можете использовать `/admins`.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный администратор или пользователь с правами "update-users"
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\Controller;

Route::get('users', [Controller::class, 'getAllUsers'])
    ->name('api_user_get_all_users')
    ->middleware(['auth:api']);
