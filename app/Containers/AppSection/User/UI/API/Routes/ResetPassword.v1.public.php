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
 * @apiName             resetPassword
 *
 * @api                 {post} /v1/password/reset Обновить пароль
 * @apiDescription      Обновление пароля пользователя.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Всем
 *
 * @apiBody             {String{40}} email Email адрес.
 * @apiBody             {String{255}} token Токен высланный на email адрес
 * @apiBody             {String{6..40}} password Новый пароль.
 *
 * @apiSuccessExample   {json}  Success-Response:
 * HTTP/1.1 204 No content
 */

use App\Containers\AppSection\User\UI\API\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::any('password/reset', ResetPasswordController::class)
    ->name('api_user_reset_password');
