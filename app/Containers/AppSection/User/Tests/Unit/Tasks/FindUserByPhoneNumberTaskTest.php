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

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\Tasks\FindUserByPhoneNumberTask;

final class FindUserByPhoneNumberTaskTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $user = User::factory()->create();

        $result = app(FindUserByPhoneNumberTask::class)->run($user->phone_number);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame($user->id, $result->id);
        $this->assertSame($user->phone_number, $result->phone_number);
    }
}
