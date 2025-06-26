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

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\AssignUserToRoleTask;
use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action;

class CreateAdminAction extends Action
{
    /**
     * @param RegisterUserDto $dto
     * @return User
     * @throws CreateResourceFailedException
     */
    public function run(RegisterUserDto $dto): User
    {
        $admin = $this->createAdmin($dto);
        $this->assignUserToRole($admin);
        return $admin;
    }

    protected function assignUserToRole(User $admin): void
    {
        app(AssignUserToRoleTask::class)->run($admin, [Role::ADMIN]);
    }

    /**
     * @param RegisterUserDto $dto
     * @return User
     * @throws CreateResourceFailedException
     */
    protected function createAdmin(RegisterUserDto $dto): User
    {
        $dto->set('is_admin', true);
        return app(CreateUserByCredentialsTask::class)->run($dto);
    }
}
