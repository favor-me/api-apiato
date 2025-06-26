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

use Illuminate\Support\Str;
use App\Ship\Parents\Tasks\Task;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;

/**
 * Class FindRoleTask
 *
 * @package App\Containers\AppSection\Authorization\Tasks
 */
class FindRoleTask extends Task
{
    /**
     * Hold repository.
     *
     * @var RoleRepository
     */
    protected RoleRepository $repository;

    /**
     * FindRoleTask constructor.
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
     * @param   $roleNameOrId
     *
     * @return  null|Role
     */
    public function run($roleNameOrId): ?Role
    {
        $query = (is_numeric($roleNameOrId) || Str::isUuid($roleNameOrId))
            ? ['id' => $roleNameOrId] : ['name' => $roleNameOrId];

        return $this->repository->findWhere($query)->first();
    }
}
