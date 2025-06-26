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
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;

/**
 * Class DeleteRoleTask
 *
 * @package App\Containers\AppSection\Authorization\Tasks
 */
class DeleteRoleTask extends Task
{
    /**
     * Hold repository.
     *
     * @var RoleRepository
     */
    protected RoleRepository $repository;

    /**
     * DeleteRoleTask constructor.
     *
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Run action.
     *
     * @param   Integer|Role $role
     *
     * @return  bool
     *
     * @throws  DeleteResourceFailedException
     */
    public function run($role): bool
    {
        if ($role instanceof Role) {
            $role = $role->id;
        }

        // delete the record from the roles table.
        try {
            return $this->repository->delete($role);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
