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

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Config\Repository;
use App\Containers\AppSection\User\Models\User;

/**
 * Class CheckIfUserEmailIsConfirmedTask
 *
 * @package App\Containers\AppSection\Authentication\Tasks
 */
class CheckIfUserEmailIsConfirmedTask extends Task
{
    /**
     * Run action.
     *
     * @param   User $user
     *
     * @return  bool
     */
    public function run(User $user): bool
    {
        if ($this->emailConfirmationIsRequired()) {
            return !is_null($user->email_verified_at);
        }

        return true;
    }

    /**
     * Check email confirmation is required.
     *
     * @return  Repository|mixed
     */
    private function emailConfirmationIsRequired()
    {
        return config('appSection-authentication.require_email_confirmation');
    }
}
