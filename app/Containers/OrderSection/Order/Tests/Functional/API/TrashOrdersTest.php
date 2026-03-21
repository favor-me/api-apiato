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
use App\Containers\ShiftSection\Item\Foundation\Item as ShiftItem;
use App\Containers\ShiftSection\Item\Models\Item as ShiftItemModel;
use Illuminate\Testing\Fluent\AssertableJson;

final class TrashOrdersTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/' . Container::getApiUri();
    }

    public function testFailedWithNoExistsIds(): void
    {
        $this->getTestingOrganizationUser([
            User::IS_ORGANIZATION_OWNER => true
        ]);

        $this->makeCall([
            IDS => [
                hash_encode(123)
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

    public function testSuccess(): void
    {
        $userOrderPercentProfit = 12;

        $user = $this->getTestingOrganizationUser([
            User::IS_ORGANIZATION_OWNER => true,
            User::SHIFT_PARAMS => [
                User::SHIFT_PARAMS_PERCENT_FROM_ORDER_PROFIT => $userOrderPercentProfit
            ]
        ]);

        $this->createUserNowShift($user);

        $model = OrderModel::factory()
            ->create([
                Order::SHIFT_ID => $this->testingUser->nowShift->id,
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $unit = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::BALANCE => 17,
                UnitPrice::COST_PRICE => app('money')->addCurrency(100)->val(),
                UnitPrice::CLIENT_PRICE => app('money')->addCurrency(150)->val(),
                OrganizationUnit::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        ItemModel::factory()
            ->unit($unit)
            ->order($model)
            ->create();

        $model->calculateTotal(true);

        $expectedProfit = 50.0;
        $this->assertSame($expectedProfit, $model->profit->currency()->val());

        $shiftItemValue = ($expectedProfit / 100) * $userOrderPercentProfit;

        ShiftItemModel::factory()
            ->create([
                ShiftItem::SHIFT_ID => $this->testingUser->nowShift->id,
                ShiftItem::ORDER_ID => $model->id,
                ShiftItem::VALUE => $shiftItemValue
            ]);

        $this->assertCount(1, $this->testingUser->nowShift->items()->get());

        $this->makeCall([
            IDS => $model->getHashedKey()
        ]);

        $this->assertCount(0, $this->testingUser->nowShift->items()->get());

        $this->testingUser->nowShift->refresh();

        $this->assertSame(0.0, $this->testingUser->nowShift->money->currency()->val());

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleTrashed(1))
                    ->etc()
            );
    }
}
