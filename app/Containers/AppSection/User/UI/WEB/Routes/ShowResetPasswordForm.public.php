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
 */

use Illuminate\Support\Facades\Route;
use App\Containers\AppSection\User\UI\WEB\Controllers\Controller;

Route::get('reset-password', [Controller::class, 'showResetPasswordForm'])
    ->name('password.show-reset-form')
    ->middleware(['guest']);
