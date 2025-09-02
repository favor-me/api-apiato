<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license Proprietary
 * @copyright Copyright (C) kalistratov.ru, All rights reserved.
 * @link https://kalistratov.ru
 *
 * @apiGroup User
 * @apiName deleteOwnUser
 * @api {delete} /v1/own/users Удалить своих сотрудников
 * @apiDescription Удаление сотрудников компании собственником.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный администратор с ролью "organization_owner"
 *
 * @apiBody {Array} ids Список id пользователей для удаления.
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
 * {
 * "message": "Успешно перемещен в корзину 1 пользователь."
 * }
 */

use App\Containers\AppSection\User\UI\API\Controllers\DeleteOwnUsersController;
use Illuminate\Support\Facades\Route;

Route::delete('own/users', DeleteOwnUsersController::class)
    ->name('api_user_delete_own_users')
    ->middleware(['auth:api']);
