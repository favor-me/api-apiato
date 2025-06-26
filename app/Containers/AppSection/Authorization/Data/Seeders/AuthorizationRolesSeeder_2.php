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

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Facades\Container;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Seeders\Seeder;

// @codingStandardsIgnoreStart

class AuthorizationRolesSeeder_2 extends Seeder
{
    /**
     * @return void
     * @throws CreateResourceFailedException
     */
    public function run(): void
    {
        $roles = collect([
            999 => Role::ADMIN
        ]);

        $apiGuard = config('auth.defaults.guard');

        $roles
            ->each(function ($name, $level) use ($apiGuard) {
                $description = Container::trans('role.' . $name . '.description');
                $displayName = Container::trans('role.' . $name . '.display_name');
                app(CreateRoleTask::class)->run($name, $description, $displayName, $level, $apiGuard);
            });
    }
}
