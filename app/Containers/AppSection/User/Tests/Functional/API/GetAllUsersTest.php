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

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class GetAllUsersTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users';

    protected array $access = [
        ROLES => 'admin',
        PERMISSIONS => 'list-users'
    ];

    public function testGetAllUsersByAdmin(): void
    {
        $defaultCount = UserModel::count();

        $users = UserModel::factory()
            ->count(2)
            ->create();

        $this->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data', $users->count() + $defaultCount + 1) // + 1 user created though makeCall() method
                ->etc()
        );
    }

    public function testGetAllUsersByNonAdmin(): void
    {
        $this->getTestingUserWithoutAccess();

        UserModel::factory()
            ->count(2)
            ->create();

        $this->makeCall();

        $this->assertActionIsUnauthorized();
    }

    public function testSearchUsersByName(): void
    {
        UserModel::factory()
            ->count(3)
            ->create();

        $name = 'Sergey';

        $this->getTestingUser([
            User::NAME => $name
        ]);

        $this
            ->endpoint($this->endpoint . '?search=name:' . $name)
            ->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data', 1)
                ->etc()
        );
    }
}
