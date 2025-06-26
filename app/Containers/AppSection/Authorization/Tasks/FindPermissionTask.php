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
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;

/**
 * Class FindPermissionTask
 *
 * @package App\Containers\AppSection\Authorization\Tasks
 */
class FindPermissionTask extends Task
{
    /**
     * Hold repository.
     *
     * @var PermissionRepository
     */
    protected PermissionRepository $repository;

    /**
     * FindPermissionTask constructor.
     *
     * @param PermissionRepository $repository
     */
    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Run action.
     *
     * @param   $permissionNameOrId
     *
     * @return  Permission
     */
    public function run($permissionNameOrId): Permission
    {
        $query = (is_numeric($permissionNameOrId) || Str::isUuid($permissionNameOrId))
            ? ['id' => $permissionNameOrId] : ['name' => $permissionNameOrId];

        return $this->repository->findWhere($query)->first();
    }
}
