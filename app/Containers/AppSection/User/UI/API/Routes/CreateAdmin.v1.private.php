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
 * @apiName             createAdmin
 * @api                 {post} /v1/admins Регистрация администратора
 * @apiDescription      Регистрация нового пользователя с правами администратора в системе.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный пользователь с правами "create-admins"
 *
 * @apiBody             {String{2..30}} name Имя.
 * @apiBody             {String{2..30}} patronymic Отчество.
 * @apiBody             {String{2..30}} surname Фамилия.
 * @apiBody             {String{40}} email Email адрес.
 * @apiBody             {String{6..40}} password Пароль.
 * @apiBody             {Boolean|String|Int="0/false = Ж", "1/true = М"} [gender] Пол.
 * @apiBody             {String=16.05.1990} [birth] День рождения.
 * @apiBody             {String{14}=+79001112233, 79001112233, 89001112233} [phone_number] Номер мобильного телефона.
 * @apiBody             {String=public,specialist} [role=public] Роль нового пользователя.
 *
 * @apiUse              UserProfileFields
 * @apiUse              UserSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\Controller;

Route::post('admins', [Controller::class, 'createAdmin'])
    ->name('api_user_create_admin')
    ->middleware(['auth:api']);
