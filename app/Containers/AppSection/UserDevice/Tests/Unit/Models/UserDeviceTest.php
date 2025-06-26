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

namespace App\Containers\AppSection\UserDevice\Tests\Unit\Models;

use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevices;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\UserDevice\Tests\UnitTestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read UserDevice $model
 */
final class UserDeviceTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->model = UserDevice::factory()->create();
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(UserDevice::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertArrayValues($this->model->getFillable(), [
            BaseUser::ID,
            BaseUserDevices::MODEL,
            BaseUserDevices::TOKEN
        ]);
    }

    public function testBelongsToUser(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->user());
        $this->assertInstanceOf(User::class, $this->model->user);
        $this->assertIsInt($this->model->user_id);
    }
}
