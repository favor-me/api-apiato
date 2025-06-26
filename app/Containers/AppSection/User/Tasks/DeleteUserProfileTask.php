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

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Auth;

class DeleteUserProfileTask extends UserTask
{
    public function run()
    {
        $authUser = Auth::user();

        if (!$authUser instanceof User) {
            throw new NotFoundException();
        }

        return $authUser->forceDelete();
    }
}
