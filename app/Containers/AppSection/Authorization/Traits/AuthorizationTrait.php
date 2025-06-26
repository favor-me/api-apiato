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

namespace App\Containers\AppSection\Authorization\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;

/**
 * Trait AuthorizationTrait
 *
 * @package App\Containers\AppSection\Authorization\Traits
 */
trait AuthorizationTrait
{
    /**
     * Return the "highest" role of a user (0 if the user does not have any role)
     *
     * @return int
     */
    public function getRoleLevel(): int
    {
        return ($role = $this->roles()->orderBy('level', 'DESC')->first()) ? $role->level : 0;
    }

    /**
     * Get user.
     *
     * @return Authenticatable|null
     */
    public function getUser(): ?Authenticatable
    {
        return app(GetAuthenticatedUserTask::class)->run();
    }

    /**
     * Check is admin role.
     *
     * @return bool
     */
    public function hasAdminRole(): bool
    {
        return $this->hasRole('admin');
    }
}
