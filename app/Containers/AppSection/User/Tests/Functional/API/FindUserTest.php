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
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class FindUserTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users/{id}';

    protected array $access = [
        ROLES => '',
        PERMISSIONS => 'search-users'
    ];

    public function testFindUser(): void
    {
        $this->getTestingUser();

        $this
            ->injectId($this->testingUser->id)
            ->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->where('data.' . User::NAME, $this->testingUser->name)
                ->etc()
        );
    }

    public function testFindFilteredUserResponse(): void
    {
        $this->getTestingUser();

        $this
            ->injectId($this->testingUser->id)
            ->endpoint($this->endpoint . '?filter=email;name')
            ->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->where('data.' . User::NAME, $this->testingUser->name)
                ->where('data.' . User::EMAIL, $this->testingUser->email)
                ->missing('data.' . ID)
        );
    }

    public function testFindUserWithRelation(): void
    {
        $this->getTestingUser();

        $this
            ->injectId($this->testingUser->id)
            ->endpoint($this->endpoint . '?include=roles')
            ->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data.roles', 1)
                ->where('data.' . User::EMAIL, $this->testingUser->email)
                ->etc()
        );
    }
}
