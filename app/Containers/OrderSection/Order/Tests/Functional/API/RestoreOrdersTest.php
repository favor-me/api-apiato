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
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\Functional\ApiTestCase;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

final class RestoreOrdersTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'post@v1/restore/' . Container::getApiUri();
    }

    public function testIsUnauthorized(): void
    {
        $this->getTestingUser(null, [
            PERMISSIONS => ''
        ]);

        $this->makeCall();

        $this->assertActionIsUnauthorized();
    }

    public function testWithTrashed(): void
    {
        $userOrderPercentProfit = 14;

        $user = $this->getTestingOrganizationUser([
            'now_shift' => true,
            User::SHIFT_PARAMS => [
                User::SHIFT_PARAMS_PERCENT_FROM_ORDER_PROFIT => $userOrderPercentProfit
            ]
        ]);

        $model = OrderModel::factory()
            ->trashed()
            ->create([
                Order::SHIFT_ID => $this->testingUser->nowShift->id,
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $unit = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::BALANCE => 8,
                UnitPrice::COST_PRICE => app('money')->addCurrency(70)->val(),
                UnitPrice::CLIENT_PRICE => app('money')->addCurrency(100)->val(),
                OrganizationUnit::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        ItemModel::factory()
            ->unit($unit)
            ->order($model)
            ->create();

        $model->calculateTotal(true);

        $expectedProfit = 30.0;
        $this->assertSame($expectedProfit, $model->profit->currency()->val());
        $this->assertSame(0.0, $this->testingUser->nowShift->money->val());
        $this->assertCount(0, $this->testingUser->nowShift->items()->get());


        $this->makeCall([
            IDS => [
                $model->getHashedKey()
            ]
        ]);

        $this->response
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleRestored($model->count()))
                    ->etc()
            );

        $this->testingUser->nowShift->refresh();

        $shiftItemValue = ($expectedProfit / 100) * $userOrderPercentProfit;

        $this->assertSame($shiftItemValue, $this->testingUser->nowShift->money->currency()->val());
        $this->assertCount(1, $this->testingUser->nowShift->items()->get());
    }

    public function testWithNotTrashed(): void
    {
        $user = $this->getTestingOrganizationUser();

        $models = OrderModel::factory()
            ->count(2)
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->makeCall([
            IDS => $models
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors', [
                    IDS . '.0' => [
                        __('validation.custom.ids.*.exists')
                    ],
                    IDS . '.1' => [
                        __('validation.custom.ids.*.exists')
                    ]
                ])
                ->etc()
        );
    }

    public function testWithOneTrashedAndOneIsNotTrashed(): void
    {
        $user = $this->getTestingOrganizationUser();

        $model = OrderModel::factory()->create();

        $modelTrashed = OrderModel::factory()
            ->trashed()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->makeCall([
            IDS => [
                $model->getHashedKey(),
                $modelTrashed->getHashedKey()
            ]
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors', [
                    IDS . '.0' => [
                        __('validation.custom.ids.*.exists')
                    ]
                ])
                ->etc()
        );
    }
}
