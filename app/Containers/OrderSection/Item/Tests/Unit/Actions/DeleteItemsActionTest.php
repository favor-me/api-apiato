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

namespace App\Containers\OrderSection\Item\Tests\Unit\Actions;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrderSection\Item\Actions\DeleteItemsAction;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Item\Tests\UnitTestCase;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;

final class DeleteItemsActionTest extends UnitTestCase
{
    public function testTrashed(): void
    {
        $models = ItemModel::factory()
            ->count(2)
            ->create();

        $ids = $models
            ->pluck(ID)
            ->toArray();

        $result = app(DeleteItemsAction::class)->run($ids);

        $this->assertSame($models->count(), $result);
    }

    public function testOrderRecalculateTotal(): void
    {
        $user = $this->getTestingOrganizationUser();

        $unitA = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::COST_PRICE => 100,
                OrganizationUnit::CLIENT_PRICE => 210,
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $unitB = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::COST_PRICE => 120,
                OrganizationUnit::CLIENT_PRICE => 150,
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $order = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id,
            ]);

        $itemA = ItemModel::factory()
            ->unit($unitA)
            ->order($order)
            ->create();

        $itemB = ItemModel::factory()
            ->unit($unitB)
            ->order($order)
            ->create();

        $order = $order->calculateTotal(true);

        // 210 + 150
        $this->assertSame(360.0, $order->total->val());

        // (210 - 100) + (150 - 120)
        $this->assertSame(140.0, $order->profit->val());

        $result = app(DeleteItemsAction::class)->run([$itemA->id]);

        $this->assertSame(1, $result);

        $order->refresh();

        // 150
        $this->assertSame(150.0, $order->total->val());

        // 150 - 120
        $this->assertSame(30.0, $order->profit->val());
    }
}
