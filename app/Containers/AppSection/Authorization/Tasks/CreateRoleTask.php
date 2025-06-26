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

use Exception;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;

/**
 * Class CreateRoleTask
 *
 * @package App\Containers\AppSection\Authorization\Tasks
 */
class CreateRoleTask extends Task
{
    /**
     * Hold repository.
     *
     * @var RoleRepository
     */
    protected RoleRepository $repository;

    /**
     * CreateRoleTask constructor.
     *
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $name
     * @param string|null $description
     * @param string|null $displayName
     * @param int $level
     * @param string $guardName
     * @return Role
     * @throws CreateResourceFailedException
     */
    public function run(
        string $name,
        string $description = null,
        string $displayName = null,
        int $level = ZERO,
        string $guardName = 'api'
    ): Role {
        app()['cache']->forget('spatie.permission.cache');

        try {
            $role = $this->repository->create([
                'name' => strtolower($name),
                'description' => $description,
                'display_name' => $displayName,
                'guard_name' => $guardName,
                'level' => $level
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }

        return $role;
    }
}
