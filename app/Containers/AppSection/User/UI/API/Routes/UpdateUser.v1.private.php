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
 * @apiName             updateUser
 * @api                 {patch} /v1/users/:id Обновить данные
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный пользователь с правами "update-users"
 *
 * @apiParam            {String} id Уникальный идентификатор пользователя.
 * @apiBody             {String{2..30}} [name] Имя.
 * @apiBody             {String{2..30}} [patronymic] Отчество.
 * @apiBody             {String{2..30}} [surname] Фамилия.
 * @apiBody             {String{40}} [email] Email адрес.
 * @apiBody             {Boolean|String|Int="0/false = Ж", "1/true = М"} [gender] Пол.
 * @apiBody             {String=16.05.1990} [birth] День рождения.
 * @apiBody             {String{14}=+79001112233, 79001112233, 89001112233} [phone_number] Номер мобильного телефона.
 *
 * @apiBody             {Int|String} [country_id] Id страны.
 *
 * @apiBody             {Int|String} [region_id] Id региона.<br/>
 *                      <strong>Примечание:</strong>
 *                      При установки значения обязательным полем становятся <code>country_id</code>
 *
 * @apiBody             {Int|String} [city_id] Id города.<br/>
 *                      <strong>Примечание:</strong>
 *                      При установки значения обязательными полями становятся
 *                      <code>country_id</code> и <code>region_id</code>
 *
 * @apiBody             {String=public,specialist} [role=public] Роль нового пользователя.
 *
 * @apiUse              UserProfileFields
 * @apiUse              UserSuccessSingleResponse
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\Controller;

Route::patch('users/{id}', [Controller::class, 'updateUser'])
    ->name('api_user_update_user')
    ->middleware(['auth:api']);
