<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteOwnUsersTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/own/users';
    }

    public function testUserNotOwn(): void
    {
        $this->getTestingOwnerUser();

        $user = UserModel::factory()->create();

        $this->makeCall([
            IDS => [
                $user->getHashedKey()
            ]
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->where('errors.' . IDS, [
                    __('validation.custom.ids.exists')
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $ownerUser = $this->getTestingOwnerUser();

        $user = UserModel::factory()
            ->create([
                User::ORGANIZATION_ID => $ownerUser->organization_id
            ]);

        $this->makeCall([
            IDS => [
                $user->getHashedKey()
            ]
        ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleTrashed(1))
                    ->etc()
            );
    }
}
