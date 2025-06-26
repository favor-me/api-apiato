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

use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;

class CreateAdminActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $dto = new RegisterUserDto($this->testData);
        $result = app(CreateAdminAction::class)->run($dto);

        $this->assertInstanceOf(User::class, $result);
        $this->assertTrue($result->is_admin);
        $this->assertTrue($result->hasRole('admin'));
        $this->assertDatabaseHas($result, ['id' => $result->id]);
    }
}
