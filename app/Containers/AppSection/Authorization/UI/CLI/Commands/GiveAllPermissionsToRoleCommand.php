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

namespace App\Containers\AppSection\Authorization\UI\CLI\Commands;

use App\Ship\Parents\Commands\ConsoleCommand;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\Tasks\GetAllPermissionsTask;
use App\Containers\AppSection\Authorization\Exceptions\RoleNotFoundException;

/**
 * Class GiveAllPermissionsToRoleCommand
 *
 * @package App\Containers\AppSection\Authorization\UI\CLI\Commands
 */
class GiveAllPermissionsToRoleCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiato:permissions:toRole {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give all system Permissions to a specific Role.';

    /**
     * Action handle.
     *
     * @throws RoleNotFoundException
     */
    public function handle(): void
    {
        $roleName = $this->argument('role');

        $allPermissions = app(GetAllPermissionsTask::class)->run(true);

        $role = app(FindRoleTask::class)->run($roleName);

        if (!$role) {
            throw new RoleNotFoundException("Role $roleName is not found!");
        }

        $role->syncPermissions($allPermissionsNames = $allPermissions->pluck('name')->toArray());

        $allPermissionsInfo = implode(' - ', $allPermissionsNames);
        $this->info('Gave the Role (' . $roleName . ') the following Permissions: ' . $allPermissionsInfo . '.');
    }
}
