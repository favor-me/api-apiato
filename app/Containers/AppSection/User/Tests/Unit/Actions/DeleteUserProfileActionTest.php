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

use App\Containers\AppSection\User\Actions\DeleteUserProfileAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class DeleteUserProfileActionTest extends UnitTestCase
{
    public function testUserNoAuth(): void
    {
        $this->expectException(NotFoundException::class);
        app(DeleteUserProfileAction::class)->run();
    }

    public function testSuccess(): void
    {
        $user = $this->getTestingUser();

        $this->assertTrue(app(DeleteUserProfileAction::class)->run());

        $this->assertDatabaseMissing(User::TABLE, [
            ID => $user->id
        ]);
    }
}
