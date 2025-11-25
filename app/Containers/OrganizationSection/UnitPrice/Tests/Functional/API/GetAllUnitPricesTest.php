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

namespace App\Containers\OrganizationSection\UnitPrice\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\Functional\ApiTestCase;
use App\Ship\Requests\ApiRequest;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllUnitPricesTest extends ApiTestCase
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

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $baseCount = UnitPriceModel::count();

        $models = UnitPriceModel::factory()
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
        $this->getTestingOrganizationOwnerUser(null, [
            ROLES => RoleModel::ORGANIZATION_OWNER
        ]);

        UnitPriceModel::factory()
            ->count(3)
            ->create();

        $trashedModels = UnitPriceModel::factory()
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
        $this->getTestingOrganizationOwnerUser(null, [
            ROLES => RoleModel::ORGANIZATION_OWNER
        ]);

        $trashedModels = UnitPriceModel::factory()
            ->count(3)
            ->trashed()
            ->create();

        UnitPriceModel::factory()
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
        $this->getTestingOrganizationUser(null, [
            ROLES => RoleModel::ORGANIZATION_WORKER
        ]);

        $baseCount = UnitPriceModel::count();

        UnitPriceModel::factory()
            ->count(5)
            ->trashed()
            ->create();

        $models = UnitPriceModel::factory()
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
        $this->getTestingOrganizationUser();

        $defaultCount = UnitPriceModel::count();

        $models = UnitPriceModel::factory()
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
                                'title'
                            ], array_keys($status));
                        });

                        return true;
                    })
                    ->etc()
            );
    }
}
