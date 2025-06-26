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

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Containers\AppSection\User\Models\User;

/**
 * Class AssignUserToRoleTask
 *
 * @package App\Containers\AppSection\Authorization\Tasks
 */
class AssignUserToRoleTask extends Task
{
    /**
     * Run action.
     *
     * @param   User $user
     * @param   array $roles
     *
     * @return  Authenticatable
     */
    public function run(User $user, array $roles): Authenticatable
    {
        return $user->assignRole($roles);
    }
}
