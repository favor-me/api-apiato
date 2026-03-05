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
 * @apiName updateUser
 * @api {patch} /v1/users/:id Обновить данные
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор пользователя.
 *
 * @apiBody {String{2..30}} [name] Имя.
 * @apiBody {String{2..30}} [patronymic] Отчество.
 * @apiBody {String{2..30}} [surname] Фамилия.
 * @apiBody {String{40}} [email] Email адрес.
 * @apiBody {Array|Object} [shift_params] Параметры смены (только для `organization_owner`).
 * @apiBody {Boolean|String|Int="0/false = Ж", "1/true = М"} [gender] Пол.
 * @apiBody {String=16.05.1990} [birth] День рождения.
 * @apiBody {String{14}=+79001112233, 79001112233, 89001112233} [phone_number] Номер мобильного телефона.
 * @apiUse  UserSuccessSingleResponse
 */

use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\UI\API\Controllers\UpdateUserController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateUserController::class)
    ->name('api_user_update_user')
    ->middleware(['auth:api']);
