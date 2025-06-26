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
 * @apiName             userLoginIsExists
 * @api                 {get} /v1/users/extra/login-exists/:login Проверить login
 * @apiDescription      Проверить занят ли логин пользователя в системе.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Общий доступ
 *
 * @apiParam            {String} login Логин пользователя.
 */

use App\Containers\AppSection\User\UI\API\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('users/extra/login-is-exists/{login}', [PublicController::class, 'existsUserLogin'])
    ->name('api_user_extra_login_exists');
