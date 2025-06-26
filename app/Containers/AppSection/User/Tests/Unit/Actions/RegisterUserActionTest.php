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

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Actions\RegisterUserAction;
use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Exceptions\CreateResourceFailedException;

class RegisterUserActionTest extends UnitTestCase
{
    public function testSuccessWithDefaultRole(): void
    {
        $dto = new RegisterUserDto($this->testData);
        $result = app(RegisterUserAction::class)->run($dto);

        $this->assertInstanceOf(User::class, $result);
        $result->hasRole(Role::CLIENT);
        $this->assertDatabaseHas($result, ['id' => $result->id]);
    }

    public function testSuccessWithSetCustomRole(): void
    {
        $dto = new RegisterUserDto(array_merge($this->testData, [
            'role' => Role::SPECIALIST
        ]));

        $result = app(RegisterUserAction::class)->run($dto);

        $this->assertInstanceOf(User::class, $result);
        $result->hasRole(Role::SPECIALIST);
        $this->assertDatabaseHas($result, ['id' => $result->id]);
    }

    public function testOnUniqueEmail(): void
    {
        $this->expectException(CreateResourceFailedException::class);

        $user = User::factory()->create();
        $dto = new RegisterUserDto($this->withTestData(['email' => $user->email]));

        app(RegisterUserAction::class)->run($dto);
    }

    public function testOnUniquePhoneNumber(): void
    {
        $this->expectException(CreateResourceFailedException::class);

        $user = User::factory()->create();
        $dto = new RegisterUserDto($this->withTestData(['phone_number' => $user->phone_number]));

        app(RegisterUserAction::class)->run($dto);
    }
}
