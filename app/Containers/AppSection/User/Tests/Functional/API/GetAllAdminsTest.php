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

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class GetAllAdminsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/admins';

    protected array $access = [
        ROLES => '',
        PERMISSIONS => 'list-users'
    ];

    public function testGetAllAdmins(): void
    {
        User::factory()->create();

        User::factory()
            ->admin()
            ->create();

        $this->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data', 2) //  1 + 1 (seeded super admin)
                ->etc()
        );
    }

    public function testGetAllAdminsByNonAdmin(): void
    {
        $this->getTestingUserWithoutAccess();

        User::factory()
            ->count(2)
            ->create();

        $this->makeCall();

        $this->assertActionIsUnauthorized();
    }
}
