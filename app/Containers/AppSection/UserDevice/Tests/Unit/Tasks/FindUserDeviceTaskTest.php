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

namespace App\Containers\AppSection\UserDevice\Tests\Unit\Tasks;

use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\UserDevice\Tasks\FindUserDeviceTask;
use App\Containers\AppSection\UserDevice\Tests\UnitTestCase;

class FindUserDeviceTaskTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $userDevice = UserDevice::factory()->create();

        $result = app(FindUserDeviceTask::class)->run($userDevice->user_id, $userDevice->model);

        $this->assertInstanceOf(UserDevice::class, $result);
        $this->assertSame($userDevice->id, $result->id);
    }

    public function testDeviceNoExists(): void
    {
        $userDevice = UserDevice::factory()->create();
        $this->assertNull(app(FindUserDeviceTask::class)->run($userDevice->user_id, 'Nokia 6230'));
    }
}
