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
 * @apiName             getAllAdmins
 * @api                 {get} /v1/admins Список администраторов
 * @apiDescription      Получить список всех пользователей с ролью `Admin`.
 *                      Вы можете осуществдять поиск по следующим полям: `email`, `name` и `ID`.
 *                      Пример: `?search=Ivan` или `?search=whatever@mail.com`.
 *                      Вы можете указать поле следующим образом ?search=email:whatever@mail.com` или `?search=id:20`.
 *                      Вы можете выполнять поиск по нескольким полям,
 *                      как показано ниже: `?search=name:Mahmoud&email:whatever@mail.com`.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный администратор
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\Controller;

Route::get('admins', [Controller::class, 'getAllAdmins'])
    ->name('api_user_get_all_admins')
    ->middleware(['auth:api']);
