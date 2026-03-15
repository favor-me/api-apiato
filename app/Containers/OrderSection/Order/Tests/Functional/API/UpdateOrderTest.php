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
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;
use App\Containers\HistorySection\ModelNote\Types\SystemMessageModelNoteType;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\Functional\ApiTestCase;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container as OrganizationUnitContainer;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateOrderTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_WORKER,
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testWithEmptyData(): void
    {
        $this->getTestingOrganizationUser();

        $this
            ->injectId(416346)
            ->makeCall();

        $this->response
            ->assertUnprocessable()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, __('ship::exception.message.empty_update_data'))
                    ->etc()
            );
    }

    public function testNotOwn(): void
    {
        $this->getTestingOrganizationUser();

        $model = OrderModel::factory()->create();

        $this
            ->injectId($model->id)
            ->makeCall([
                Order::COMMENT => 'Comment'
            ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . ID, [
                    __('validation.custom.id.exists')
                ])
                ->etc()
        );
    }

    public function testWithInvalidId(): void
    {
        $this->getTestingOrganizationUser();

        $data = [
            Order::COMMENT => 'Comment'
        ];

        $this
            ->injectId(123123)
            ->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . ID, [
                    __('validation.custom.id.exists')
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $unitA = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::COST_PRICE => app('money')->addCurrency(100)->val(),
                UnitPrice::CLIENT_PRICE => app('money')->addCurrency(210)->val(),
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $unitB = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::COST_PRICE => app('money')->addCurrency(120)->val(),
                UnitPrice::CLIENT_PRICE => app('money')->addCurrency(150)->val(),
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $unitC = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::COST_PRICE => app('money')->addCurrency(100)->val(),
                UnitPrice::CLIENT_PRICE => app('money')->addCurrency(110)->val(),
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $order = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $itemA = ItemModel::factory()
            ->unit($unitA)
            ->order($order)
            ->create();

        ItemModel::factory()
            ->unit($unitB)
            ->order($order)
            ->create();

        $order = $order->calculateTotal(true);

        $this->assertSame(360.0, $order->total->currency()->val());
        $this->assertCount(2, $order->items);

        $data = [
            Order::TOTAL => 900, // (210 * 2) + 150 + (110 * 3) = 900
            Order::COMMENT => 'Comment',
            Order::ITEMS => [
                [
                    Item::NAME => $unitC->name,
                    Item::UNIT_ID => $unitC->getHashedKey(),
                    Item::SKU => $unitC->sku,
                    Item::COST_PRICE => $unitC->cost_price->currency()->val(),
                    Item::CLIENT_PRICE => $unitC->client_price->currency()->val(),
                    Item::AMOUNT => 3
                ],
                [
                    ID => $itemA->getHashedKey(),
                    Item::NAME => $itemA->name,
                    Item::UNIT_ID => $unitA->getHashedKey(),
                    Item::SKU => $itemA->sku,
                    Item::COST_PRICE => $itemA->cost_price->currency()->val(),
                    Item::CLIENT_PRICE => $itemA->client_price->currency()->val(),
                    Item::AMOUNT => 2
                ]
            ]
        ];

        $this
            ->injectId($order->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $order->getHashedKey())
                    ->where('data.' . Order::COMMENT, $data[Order::COMMENT])
                    ->where('data.' . Order::TOTAL . '.currency.value', $data[Order::TOTAL])
                    ->has('data.' . Order::ITEMS . '.data', 3)
                    ->where('data.' . Order::ITEMS . '.data', function (Collection $items) use ($itemA, $unitC) {
                        $items
                            ->each(function (array $item) use ($itemA, $unitC) {
                                if ($item[ID] === $itemA->getHashedKey()) {
                                    self::assertSame(2, $item[Item::AMOUNT]);
                                }
                                if ($item[ID] === $unitC->getHashedKey()) {
                                    self::assertSame(3, $item[Item::AMOUNT]);
                                }
                            });

                        return true;
                    })
                    ->etc()
            );
    }

    public function testCanUpdateStatus(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $status = StatusModel::factory()->create();

        $data = [
            Order::STATUS_ID => $status->getHashedKey()
        ];

        $this
            ->injectId($order->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . Order::STATUS_ID, $status->getHashedKey())
                    ->etc()
            );
    }

    public function testCantUpdateStatus(): void
    {
        $user = $this->getTestingOrganizationUser();

        $statusA = StatusModel::factory()->create();
        $statusB = StatusModel::factory()->create();

        $order = OrderModel::factory()
            ->create([
                Order::STATUS_ID => $statusA->id,
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $data = [
            Order::STATUS_ID => $statusB->getHashedKey()
        ];

        $this
            ->injectId($order->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . Order::STATUS_ID, $statusA->getHashedKey())
                    ->etc()
            );
    }

    public function testCantUpdateCompletedOrder(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->completed()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $data = [
            Order::COMMENT => 'Comment'
        ];

        $this
            ->injectId($order->id)
            ->makeCall($data);

        $this->response
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('message')
                    ->where('message', Container::trans('container.cant_update'))
                    ->etc()
            );
    }

    public function testCantUpdateCanceledOrder(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->canceled()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $data = [
            Order::COMMENT => 'Comment'
        ];

        $this
            ->injectId($order->id)
            ->makeCall($data);

        $this->response
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('message')
                    ->where('message', Container::trans('container.cant_update'))
                    ->etc()
            );
    }

    public function testSuccessCompletedOrder(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $unitA = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::BALANCE => 17,
                UnitPrice::COST_PRICE => app('money')->addCurrency(50)->val(),
                UnitPrice::CLIENT_PRICE => app('money')->addCurrency(60)->val(),
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $unitInfinityBalance = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::BALANCE => 0,
                UnitPrice::IS_INFINITY_BALANCE => true,
                UnitPrice::COST_PRICE => app('money')->addCurrency(50)->val(),
                UnitPrice::CLIENT_PRICE => app('money')->addCurrency(60)->val(),
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $itemA = ItemModel::factory()
            ->unit($unitA)
            ->order($order)
            ->create();

        ItemModel::factory()
            ->unit($unitInfinityBalance)
            ->order($order)
            ->create();

        $data = [
            Order::STATUS_ID => $this->getCompletedStatus()->getHashedKey()
        ];

        $this
            ->injectId($order->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . Order::STATUS_ID, $data[Order::STATUS_ID])
                    ->etc()
            );

        /** Start Test Unit A  */
        $oldUnitA = clone $unitA;
        $unitA->refresh();

        $newUnitABalance = $oldUnitA->balance - $itemA->amount;

        $this->assertSame($newUnitABalance, $unitA->balance);

        $unitAFirstNote = $unitA->modelNotes->first();

        $this->assertInstanceOf(ModelNote::class, $unitAFirstNote);
        $this->assertSame(OrganizationUnitModel::class, $unitAFirstNote->model);
        $this->assertSame($unitA->id, $unitAFirstNote->model_id);
        $this->assertSame(
            OrganizationUnitContainer::transFullKey('history.minus_organization_unit_balance.note_message'),
            $unitAFirstNote->params->get(SystemMessageModelNoteType::PARAM_KEY_MESSAGE)
        );

        $this->assertSame([
            'old_value' => (int)$oldUnitA->balance,
            'new_value' => (int)$newUnitABalance
        ], $unitAFirstNote->params->get(SystemMessageModelNoteType::PARAM_KEY_MESSAGE_ARGS));
        /** End Test Unit A  */

        /** Start Test Unit infinity  */
        $oldUnitInfinityBalance = clone $unitInfinityBalance;
        $unitInfinityBalance->refresh();
        $this->assertSame($oldUnitInfinityBalance->balance, $unitInfinityBalance->balance);

        $unitInfinityFirstNote = $unitInfinityBalance->modelNotes->first();

        $this->assertInstanceOf(ModelNote::class, $unitInfinityFirstNote);
        $this->assertSame(OrganizationUnitModel::class, $unitInfinityFirstNote->model);
        $this->assertSame($unitInfinityBalance->id, $unitInfinityFirstNote->model_id);

        $this->assertSame(
            OrganizationUnitContainer::transFullKey('history.minus_organization_unit_balance.note_message'),
            $unitInfinityFirstNote->params->get(SystemMessageModelNoteType::PARAM_KEY_MESSAGE)
        );

        $this->assertSame([
            'old_value' => 0,
            'new_value' => 0
        ], $unitInfinityFirstNote->params->get(SystemMessageModelNoteType::PARAM_KEY_MESSAGE_ARGS));
        /** Finish Test Unit infinity  */
    }
}
