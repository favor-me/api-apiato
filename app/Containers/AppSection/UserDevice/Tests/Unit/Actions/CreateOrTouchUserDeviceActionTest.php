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

namespace App\Containers\AppSection\UserDevice\Tests\Unit\Actions;

use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Actions\CreateOrTouchUserDeviceAction;
use App\Containers\AppSection\UserDevice\Dto\CreateUserDeviceDto;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\UserDevice\Tests\UnitTestCase;

final class CreateOrTouchUserDeviceActionTest extends UnitTestCase
{
    public function testSuccessCreate(): void
    {
        $dto = new CreateUserDeviceDto(
            UserDevice::factory()
                ->make()
                ->toArray()
        );

        $result = app(CreateOrTouchUserDeviceAction::class)->run($dto);

        $this->assertInstanceOf(UserDevice::class, $result);
        $this->assertSame($dto->user_id, $result->user_id);
        $this->assertSame($dto->model, $result->model);
        $this->assertSame($dto->token, $result->token);
    }

    public function testSuccessTouch(): void
    {
        $userDevice = UserDevice::factory()->create();

        $dto = new CreateUserDeviceDto([
            BaseUser::ID => $userDevice->user_id,
            BaseUserDevice::MODEL => $userDevice->model,
            BaseUserDevice::TOKEN => $userDevice->token
        ]);

        $sleep = 3;
        sleep($sleep);

        $result = app(CreateOrTouchUserDeviceAction::class)->run($dto);

        $this->assertInstanceOf(UserDevice::class, $result);
        $this->assertSame($userDevice->id, $result->id);
        $this->assertSame($userDevice->user_id, $result->user_id);
        $this->assertSame($userDevice->token, $result->token);

        $this->assertNotEquals($userDevice->created_at->getTimestamp(), $result->updated_at->getTimestamp());
        $this->assertSame($userDevice->created_at->getTimestamp() + $sleep, $result->updated_at->getTimestamp());
    }
}
