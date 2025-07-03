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
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateOwnOrganizationUserTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/own/users';

    public function testIsNotOwner(): void
    {
        $this->makeCall([
            User::NAME => 'Vladimir'
        ]);

        $this->assertActionIsUnauthorized();
    }

    public function testSuccess(): void
    {
        $organizationBranch = OrganizationBranchModel::factory()->create();

        $organizationOwnUser = $organizationBranch->organization->userOwner;

        $organizationOwnUser->assignRole(RoleModel::ORGANIZATION_OWNER);

        $organizationOwnUser
            ->setAttribute(User::ORGANIZATION_ID, $organizationBranch->organization_id)
            ->setAttribute(User::IS_ORGANIZATION_OWNER, true)
            ->save();

        $this->testingUser = $organizationOwnUser;

        $data = [
            User::NAME => 'Vladimir',
            User::PASSWORD => 123456,
            User::ORGANIZATION_BRANCH_ID => $organizationBranch->getHashedKey()
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . User::NAME, $data[User::NAME])
                    ->where('data.' . User::ORGANIZATION_ID, $organizationBranch->organization->getHashedKey())
                    ->where('data.' . User::ORGANIZATION_BRANCH_ID, $data[User::ORGANIZATION_BRANCH_ID])
                    ->where('data.' . User::IS_ORGANIZATION_OWNER, null)
                    ->etc()
            );
    }
}
