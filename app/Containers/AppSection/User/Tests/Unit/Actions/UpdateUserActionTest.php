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

use App\Containers\AppSection\User\Actions\UpdateUserAction;
use App\Containers\AppSection\User\Dto\UpdateUserDto;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;

class UpdateUserActionTest extends UnitTestCase
{
    public function testWithEmptyData(): void
    {
        $this->expectException(InternalErrorException::class);
        $this->expectExceptionMessage(__('ship::exception.inputs_empty'));

        $dto = new UpdateUserDto(['id' => 10000]);
        app(UpdateUserAction::class)->run($dto);
    }

    public function testNoFoundUpdatedUser(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(__('appSection@user::user.not_found'));

        $dto = new UpdateUserDto([
            'id' => 10000,
            'name' => 'Ivan'
        ]);

        app(UpdateUserAction::class)->run($dto);
    }

    public function testSuccessUpdateUser(): void
    {
        $user = User::factory()->create();

        $dto = new UpdateUserDto([
            'id' => $user->id,
            'name' => 'Ivan',
            'login' => 'ivan-164'
        ]);

        $result = app(UpdateUserAction::class)->run($dto);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame($dto->name, $result->name);
        $this->assertSame($dto->login, $result->login);
    }
}
