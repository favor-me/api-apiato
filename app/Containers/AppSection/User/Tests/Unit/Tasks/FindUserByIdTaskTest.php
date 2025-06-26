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

namespace App\Containers\AppSection\User\Tests\Unit\Tasks;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindUserByIdTaskTest extends UnitTestCase
{
    public function testWithRoleExists(): void
    {
        $role = Role::factory()->create();

        $user = User::factory()->create();
        $user->assignRole($role->name);

        $result = app(FindUserByIdTask::class)
            ->role($role->name)
            ->run($user->id);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame($user->id, $result->id);
        $this->assertTrue($result->hasRole($role->name));
    }

    public function testWithRoleInvalid(): void
    {
        $this->expectException(NotFoundException::class);

        $roleOne = Role::factory()->create();
        $roleTwo = Role::factory()->create();

        $userOne = User::factory()->create();
        $userOne->assignRole($roleOne->name);

        $userTwo = User::factory()->create();
        $userTwo->assignRole($roleTwo->name);

        app(FindUserByIdTask::class)
            ->role($roleOne->name)
            ->run($userTwo->id);
    }
}
