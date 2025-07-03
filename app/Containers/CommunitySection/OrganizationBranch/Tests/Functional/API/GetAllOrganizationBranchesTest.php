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
use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\Functional\ApiTestCase;
use App\Ship\Parents\Requests\Request;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllOrganizationBranchesTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ADMIN,
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri();
    }

    public function testSuccess(): void
    {
        $models = OrganizationBranchModel::factory()
            ->count(2)
            ->create();

        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $models->count())
                    ->etc()
            );
    }

    public function testOnlyTrashed(): void
    {
        $this->getTestingUser(null, [
            ROLES => RoleModel::ADMIN
        ]);

        OrganizationBranchModel::factory()
            ->count(3)
            ->create();

        $trashedModels = OrganizationBranchModel::factory()
            ->trashed()
            ->create();

        $this
            ->endpoint($this->endpoint . '?' . Request::ONLY_TRASHED . '=1')
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', 1)
                    ->where('data.0.' . ID, $trashedModels->getHashedKey())
                    ->etc()
            );
    }

    public function testCanReadOnlyTrashedList(): void
    {
        $this->getTestingUser(null, [
            ROLES => [
                RoleModel::ADMIN,
                RoleModel::ORGANIZATION_OWNER
            ]
        ]);

        $trashedModels = OrganizationBranchModel::factory()
            ->count(3)
            ->trashed()
            ->create();

        OrganizationBranchModel::factory()
            ->count(2)
            ->create();

        $this
            ->endpoint($this->endpoint . '?' . Request::ONLY_TRASHED . '=1')
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $trashedModels->count())
                    ->etc()
            );
    }

    public function testCantReadOnlyTrashedList(): void
    {
        $this->getTestingUser(null, [
            ROLES => [
                RoleModel::ORGANIZATION_OWNER
            ]
        ]);

        $baseCount = OrganizationBranchModel::count();

        OrganizationBranchModel::factory()
            ->count(5)
            ->trashed()
            ->create();

        $models = OrganizationBranchModel::factory()
            ->count(6)
            ->create();

        $this
            ->endpoint($this->endpoint . '?' . Request::ONLY_TRASHED . '=1')
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $baseCount + $models->count())
                    ->etc()
            );
    }

    public function testToList(): void
    {
        $defaultCount = OrganizationBranchModel::count();

        $models = OrganizationBranchModel::factory()
            ->count(3)
            ->create();

        $this
            ->endpoint($this->endpoint . '?to=' . ApiRequest::TO_LIST_VALUE)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->where('meta.pagination.total', $defaultCount + $models->count())
                    ->where('data', function (Collection $statuses) {
                        $statuses->each(function ($status) {
                            $this->assertSame([
                                'value',
                                'title',
                            ], array_keys($status));
                        });

                        return true;
                    })
                    ->etc()
            );
    }
}
