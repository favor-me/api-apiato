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

namespace App\Ship\Seeders;

use App\Containers\AppSection\Authorization\Dto\CreatePermissionDto;
use App\Containers\AppSection\Authorization\Tasks\CreatePermissionTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Seeders\Seeder;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

abstract class PermissionsSeeder extends Seeder
{
    protected ?string $permissionClass;

    /**
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function run(): void
    {
        $createPermissionTask = app(CreatePermissionTask::class);

        (new $this->permissionClass())
            ->getList()
            ->each(function (CreatePermissionDto $permissionDto) use ($createPermissionTask) {
                $createPermissionTask->run($permissionDto);
            });
    }
}
