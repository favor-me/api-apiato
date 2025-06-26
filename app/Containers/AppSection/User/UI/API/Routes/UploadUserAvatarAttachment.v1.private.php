<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\API\Controllers\UploadUserAvatarAttachmentController;

Route::post('user/attachments/upload/avatar', UploadUserAvatarAttachmentController::class)
    ->name('api_user_upload_user_avatar_attachment')
    ->middleware(['auth:api']);
