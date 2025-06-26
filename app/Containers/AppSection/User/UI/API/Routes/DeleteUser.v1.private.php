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
 * @apiName             deleteUser
 * @api                 {delete} /v1/users Удалить
 * @apiDescription      Удаление любого пользователя из системы.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный администратор с правами "delete-users"
 *
 * @apiBody             {Array} ids Список id пользователей для удаления.
 *
 * @apiSuccessExample   {json}   Success-Response:
 * HTTP/1.1 204 No content
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\Controller;

Route::delete('users', [Controller::class, 'deleteUser'])
    ->name('api_user_delete_user')
    ->middleware(['auth:api']);
