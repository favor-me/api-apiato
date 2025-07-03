<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\CommunitySection\OrganizationBranch\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateOrganizationBranchTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testNotOwn(): void
    {
        $model = OrganizationBranchModel::factory()->create();
        $this->assertInstanceOf(OrganizationBranchModel::class, $model);

        $this->getTestingUser()
            ->assignRole(RoleModel::ORGANIZATION_OWNER);

        $this
            ->injectId($model->id)
            ->makeCall([
                OrganizationBranch::NAME => 'New name'
            ]);

        $this->response
            ->assertForbidden()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('message')
                    ->where('message', __('ship::exception.unauthorized_action'))
                    ->etc()
            );
    }

    public function testSuccessOwn(): void
    {
        $model = OrganizationBranchModel::factory()->create();
        $this->assertInstanceOf(OrganizationBranchModel::class, $model);

        $user = $model->organization->userOwner;

        $user->assignRole(RoleModel::ORGANIZATION_OWNER);

        $user
            ->setAttribute(User::ORGANIZATION_ID, $model->organization_id)
            ->setAttribute(User::IS_ORGANIZATION_OWNER, true)
            ->save();

        $this->testingUser = $user;

        $data = [
            OrganizationBranch::NAME => 'New name'
        ];

        $this
            ->injectId($model->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $model->getHashedKey())
                    ->where('data.' . OrganizationBranch::NAME, $data[OrganizationBranch::NAME])
                    ->etc()
            );
    }
}
