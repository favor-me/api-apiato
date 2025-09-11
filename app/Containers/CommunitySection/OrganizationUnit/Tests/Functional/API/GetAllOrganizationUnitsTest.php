<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\ApiTestCase;
use App\Ship\Parents\Requests\Request;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllOrganizationUnitsTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri();
    }

    public function testNowOwn(): void
    {
        OrganizationUnitModel::factory()
            ->count(3)
            ->create();

        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', ZERO)
                    ->etc()
            );
    }

    public function testOwnSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $models = OrganizationUnitModel::factory()
            ->count(3)
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('meta.pagination.total', $models->count())
                    ->etc()
            );
    }

    public function testOnlyTrashed(): void
    {
        $user = $this->getTestingOrganizationUser(null, [
            ROLES => RoleModel::ORGANIZATION_OWNER
        ]);

        OrganizationUnitModel::factory()
            ->count(3)
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $trashedModels = OrganizationUnitModel::factory()
            ->trashed()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

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
        $user = $this->getTestingOrganizationUser(null, [
            ROLES => [
                RoleModel::ORGANIZATION_OWNER,
                RoleModel::ORGANIZATION_WORKER
            ]
        ]);

        $trashedModels = OrganizationUnitModel::factory()
            ->count(3)
            ->trashed()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        OrganizationUnitModel::factory()
            ->count(2)
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

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
        $user = $this->getTestingOrganizationUser(null, [
            ROLES => [
                RoleModel::ORGANIZATION_WORKER
            ]
        ]);

        OrganizationUnitModel::factory()
            ->count(5)
            ->trashed()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $models = OrganizationUnitModel::factory()
            ->count(6)
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $this
            ->endpoint($this->endpoint . '?' . Request::ONLY_TRASHED . '=1')
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $models->count())
                    ->etc()
            );
    }

    public function testToList(): void
    {
        $user = $this->getTestingOrganizationUser();

        $models = OrganizationUnitModel::factory()
            ->count(3)
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $this
            ->endpoint($this->endpoint . '?to=' . ApiRequest::TO_LIST_VALUE)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->where('meta.pagination.total', $models->count())
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
