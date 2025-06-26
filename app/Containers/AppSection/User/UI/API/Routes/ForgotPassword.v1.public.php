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
 * @apiName             forgotPassword
 *
 * @api                 {post} /v1/password/forgot Напомнить пароль
 * @apiDescription      Создание токена, отправка его на почту для последующей смены пароля.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный пользователь
 *
 * @apiBody             {String{40}} email Email адрес.
 * @apiBody             {String} reset_url Полный адрес страницы с которой осуществляется запрос
 *
 * @apiSuccessExample   {json}  Success-Response:
 * HTTP/1.1 202 OK
 * {}
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\Controller;

Route::post('password/forgot', [Controller::class, 'forgotPassword'])
    ->name('api_user_forgot_password');
