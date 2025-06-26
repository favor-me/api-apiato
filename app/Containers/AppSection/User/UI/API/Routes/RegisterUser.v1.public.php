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
 * @apiName             registerUser
 * @api                 {post} /v1/register Регистрация пользователя
 * @apiDescription      Регистрация нового пользователя в системе.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Всем
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
 * @apiBody             {String{191}} [login] Уникальное название (ссылка/логин) профиля.
 *
 * @apiUse              UserProfileFields
 * @apiUse              UserSuccessSingleResponse
 */

use App\Containers\AppSection\User\UI\API\Controllers\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterUserController::class)
    ->name('api_user_register_user');
