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

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteUserTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/users';

    protected array $access = [
        ROLES => Role::ADMIN,
        PERMISSIONS => 'delete-users'
    ];

    public function testDeleteExistingUser(): void
    {
        $this->getTestingUser();

        $this->makeCall([
            IDS => [
                $this->testingUser->getHashedKey()
            ]
        ]);

        $this->response->assertNoContent();
        $this->assertSoftDeleted($this->testingUser);
    }

    public function testDeleteWithInvalidId(): void
    {
        $this->makeCall([
            IDS => [
                hash_encode(111111)
            ]
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->where('errors.' . IDS, [__('validation.custom.ids.exists')])
                ->etc()
        );
    }

    public function testDeleteSuperuser(): void
    {
        $this->makeCall([
            IDS => [
                $this->getSuperUser()->getHashedKey()
            ]
        ]);

        $this->response->assertStatus(Response::HTTP_EXPECTATION_FAILED);

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->where(MESSAGE, __('ship::exception.unable_to_remove_superuser'))
                ->etc()
        );
    }

    public function testDeleteSuperuserAndOtherUserTogether(): void
    {
        $user = User::factory()->create();

        $this->makeCall([
            IDS => [
                $user->getHashedKey(),
                $this->getSuperUser()->getHashedKey()
            ]
        ]);

        $this->response->assertStatus(Response::HTTP_EXPECTATION_FAILED);

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->where(MESSAGE, __('ship::exception.unable_to_remove_superuser'))
                ->etc()
        );
    }

    public function testDeleteMultipleUsers(): void
    {
        $users = User::factory()
            ->count(10)
            ->create();

        $this->makeCall([
            IDS => $users
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->response->assertNoContent();

        $users->each(
            fn(User $user) => $this->assertSoftDeleted($user)
        );
    }
}
