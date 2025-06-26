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
 * @apiGroup            UserDevice
 * @apiName             createOrUpdateUserDevice
 * @apiUse              UserDeviceSuccessSingleResponse
 *
 * @api                 {post} /v1/user/:user_id/devices Создать или обновить
 * @apiDescription      Создать новое устройсво или обновить существующее.
 *
 * @apiVersion          1.0.0
 * @apiPermission       Аутентифицированный пользователь
 *
 * @apiParam            {String} user_id Уникальный идентификатор пользователя.
 * @apiBody             {String{1..100}} model Модель устройства.
 * @apiBody             {String{1..191}} token Токен устройтсва.
 */

use App\Containers\AppSection\UserDevice\Facades\Container;
use App\Containers\AppSection\UserDevice\UI\API\Controllers\Controller;

Route::post(Container::getApiUri(), [Controller::class, 'createOrTouchUserDevice'])
    ->name('api_user_device_create_or_touch_user_device')
    ->middleware(['auth:api']);
