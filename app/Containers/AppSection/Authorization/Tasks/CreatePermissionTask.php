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

use App\Containers\AppSection\Authorization\Dto\CreatePermissionDto;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use Exception;

class CreatePermissionTask extends Task
{
    protected PermissionRepository $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreatePermissionDto|string $dto
     * @return Permission
     * @throws CreateResourceFailedException
     */
    public function run(CreatePermissionDto|string $dto): Permission
    {
        app()['cache']->forget('spatie.permission.cache');

        try {
            if (is_string($dto)) {
                $dto = new CreatePermissionDto([
                    'name' => $dto
                ]);
            }

            $permission = $this->repository->create($dto->toArray());
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }

        return $permission;
    }
}
