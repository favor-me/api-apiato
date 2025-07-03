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
 * @apiName             createOwnOrganizationUser
 * @api                 {post} /v1/own/users Регистрация сотрудника компании
 * @apiDescription      Регистрация нового сотрудника организации.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный пользователь (собственник организации)
 *
 * @apiBody             {String{2..30}} name Имя.
 * @apiBody             {String{6..40}} password Пароль.
 * @apiBody             {String{6..40}} organization_branch_id Уникальный идентификатор отделения организации.
 * @apiBody             {String{2..30}} [patronymic] Отчество.
 * @apiBody             {String{2..30}} [surname] Фамилия.
 * @apiBody             {String{40}} [email] Email адрес.
 * @apiBody             {Boolean|String|Int="0/false = Ж", "1/true = М"} [gender] Пол.
 * @apiBody             {String=16.05.1990} [birth] День рождения.
 * @apiBody             {String{14}=+79001112233, 79001112233, 89001112233} [phone_number] Номер мобильного телефона.
 *
 * @apiUse              UserSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\CreateOwnOrganizationUserController;

Route::post('own/users', CreateOwnOrganizationUserController::class)
    ->name('api_user_create_own_organization_user')
    ->middleware(['auth:api']);
