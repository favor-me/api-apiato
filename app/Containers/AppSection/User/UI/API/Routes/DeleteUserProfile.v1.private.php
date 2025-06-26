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
 * @apiName             deleteUserProfile
 * @api                 {delete} /v1/user/profile Удалить свой профиль
 * @apiDescription      Удаление профиля без возвратно.
 *
 * @apiVersion          1.0.0
 *
 * @apiSuccessExample   {json} Ответ:
 * HTTP/1.1 200 OK
{
    "message": "Ваш профиль был удалён безвозвратно"
}
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\Controller;

Route::delete('user/profile', [Controller::class, 'deleteUserProfile'])
    ->name('api_user_delete_profile')
    ->middleware(['auth:api']);
