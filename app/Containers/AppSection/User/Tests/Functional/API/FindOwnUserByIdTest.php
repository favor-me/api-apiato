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
use App\Containers\CommunitySection\Organization\Models\Organization;
use Illuminate\Testing\Fluent\AssertableJson;

final class FindOwnUserByIdTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/own/users/{' . ID . '}';
    }

    public function testAuthUserIsNotOrganizationOwner(): void
    {
        $user = UserModel::factory()->create();

        $this
            ->injectId($user->id)
            ->makeCall();

        $this->response
            ->assertNotFound()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('message')
                    ->where('message', Container::trans('user.user_is_not_organization_owner'))
                    ->etc()
            );
    }

    public function testUserNotFound(): void
    {
        $this->getTestingOwnerUser();

        $user = UserModel::factory()->create();

        $this
            ->injectId($user->id)
            ->makeCall();

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->where('errors.' . ID, [
                    __('validation.custom.id.exists')
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $owner = $this->getTestingOwnerUser();

        $user = UserModel::factory()
            ->create([
                User::ORGANIZATION_ID => $owner->organization_id
            ]);

        $this
            ->injectId($user->id)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.id', $user->getHashedKey())
                    ->etc()
            );
    }

    protected function getTestingOwnerUser(): UserModel
    {
        $organization = Organization::factory()->create();

        return $this->getTestingUser([
            User::ORGANIZATION_ID => $organization->id,
            User::IS_ORGANIZATION_OWNER => true
        ]);
    }
}
