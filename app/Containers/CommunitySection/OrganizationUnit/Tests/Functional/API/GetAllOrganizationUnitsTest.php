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

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Permissions\Permissions;
use App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\ApiTestCase;
use App\Ship\Requests\ApiRequest;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllOrganizationUnitsTest extends ApiTestCase
{
    protected array $access = [
        PERMISSIONS => Permissions::READ
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri();
    }

    public function testSuccess(): void
    {
        $baseCount = OrganizationUnitModel::count();

        $models = OrganizationUnitModel::factory()
            ->count(3)
            ->create();

        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('meta.pagination.total', $models->count() + $baseCount)
                    ->etc()
            );
    }

    public function testOnlyTrashed(): void
    {
        $this->getTestingUser(null, [
            PERMISSIONS => Permissions::READ_ARCHIVE
        ]);

        OrganizationUnitModel::factory()
            ->count(3)
            ->create();

        $trashedModels = OrganizationUnitModel::factory()
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
            PERMISSIONS => [
                Permissions::READ,
                Permissions::READ_ARCHIVE
            ]
        ]);

        $trashedModels = OrganizationUnitModel::factory()
            ->count(3)
            ->trashed()
            ->create();

        OrganizationUnitModel::factory()
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
            PERMISSIONS => [
                Permissions::READ
            ]
        ]);

        $baseCount = OrganizationUnitModel::count();

        OrganizationUnitModel::factory()
            ->count(5)
            ->trashed()
            ->create();

        $models = OrganizationUnitModel::factory()
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
        $defaultCount = OrganizationUnitModel::count();

        $models = OrganizationUnitModel::factory()
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
                                VALUE,
                                TITLE,
                            ], array_keys($status));
                        });

                        return true;
                    })
                    ->etc()
            );
    }
}
