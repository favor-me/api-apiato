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
 * @apiName getAllOwnOrganizationUsers
 *
 * @api {get} /v1/own/users Список сотрудников моей компании
 * @apiDescription Получить список всех сотрудников моей компании кроме меня.
 *
 * @apiParam {String} [exclude-auth=0,1] Исключить аутентифицированного пользователя из списка.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь - собственник компании.
 */

use App\Containers\AppSection\User\UI\API\Controllers\GetAllOwnOrganizationUsersController;
use Illuminate\Support\Facades\Route;

Route::get('own/users', GetAllOwnOrganizationUsersController::class)
    ->name('api_user_get_all_own_users')
    ->middleware(['auth:api']);
