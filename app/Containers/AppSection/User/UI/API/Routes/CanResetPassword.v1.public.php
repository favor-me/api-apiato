<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 *
 * @apiGroup User
 * @apiName canResetPassword
 * @api {post} /v1/password/reset/check Проверить обновления пароля
 * @apiDescription Проверяет доступ для дальнейшего обновления пароля. Возможна ли смена пароля.
 *
 * @apiVersion 1.0.0
 * @apiPermission Всем
 *
 * @apiBody {String{14}} value Номер телефона.
 * @apiBody {String{255}} token Токен
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 204 No content
 */

use App\Containers\AppSection\User\UI\API\Controllers\CanResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::any('password/reset/check', CanResetPasswordController::class)
    ->name('api_user_reset_password_check');
