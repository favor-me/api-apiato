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

namespace App\Containers\OrderSection\Order\Tests\Unit\Actions;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Actions\UpdateOrderAction;
use App\Containers\OrderSection\Order\Dto\UpdateOrderDto;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateOrderActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = OrderModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateOrderDto($data->toArray());
        app(UpdateOrderAction::class)->run($dto);
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

        $data = OrderModel::factory()
            ->make([
                ID => $order->id,
                Order::TOTAL => 100,
                Order::ITEMS => [
                    [
                        ID => $itemA->id,
                        Item::NAME => $itemA->name,
                        Item::UNIT_ID => $itemA->id,
                        Item::SKU => $itemA->sku,
                        Item::COST_PRICE => $itemA->cost_price->val(),
                        Item::CLIENT_PRICE => $itemA->client_price->val(),
                        Item::AMOUNT => 2
                    ]
                ]
            ]);

        $dto = new UpdateOrderDto($data->toArray());

        $result = app(UpdateOrderAction::class)->run($dto);

        $this->assertInstanceOf(OrderModel::class, $result);

        $this->assertSame(570.0, $result->total->currency()->val());
        $this->assertCount(2, $result->items);
    }
}
