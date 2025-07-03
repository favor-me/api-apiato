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
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllOwnOrganizationUsersTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/own/users';
    }

    public function test(): void
    {
        $organization = OrganizationModel::factory()->create();

        $organizationOwner = $organization->userOwner
            ->assignRole(RoleModel::ORGANIZATION_OWNER);

        $organizationOwner
            ->setAttribute(User::ORGANIZATION_ID, $organization->id)
            ->setAttribute(User::IS_ORGANIZATION_OWNER, true)
            ->save();

        $this->testingUser = $organizationOwner;

        $ownUsers = UserModel::factory()
            ->count(2)
            ->create([
                User::ORGANIZATION_ID => $organization->id
            ]);

        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $ownUsers->count())
                    ->etc()
            );
    }
}
