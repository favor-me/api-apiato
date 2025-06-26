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

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteUserProfileTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/user/profile';

    public function test(): void
    {
        $this->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has(MESSAGE)
                ->where(MESSAGE, Container::trans('user.profile_deleted'))
                ->etc()
        );

        $this->assertDatabaseMissing(User::TABLE, [
            ID => $this->testingUser->id
        ]);
    }
}
