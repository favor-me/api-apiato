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

namespace App\Containers\OrderSection\Order\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\Functional\ApiTestCase;
use App\Ship\Parents\Requests\Request;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllOrdersTest extends ApiTestCase
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
        $user = $this->getTestingOrganizationUser();

        $models = OrderModel::factory()
            ->count(3)
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
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

        OrderModel::factory()
            ->count(3)
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        OrderModel::factory()
            ->trashed()
            ->create();

        $trashedModels = OrderModel::factory()
            ->trashed()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
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
        $user = $this->getTestingOrganizationUser();

        $trashedModels = OrderModel::factory()
            ->count(3)
            ->trashed()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        OrderModel::factory()
            ->count(2)
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
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

        OrderModel::factory()
            ->count(5)
            ->trashed()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $models = OrderModel::factory()
            ->count(6)
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
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

        $models = OrderModel::factory()
            ->count(3)
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
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
                                'title'
                            ], array_keys($status));
                        });

                        return true;
                    })
                    ->etc()
            );
    }
}
