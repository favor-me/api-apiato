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

namespace App\Containers\OrderSection\Item\Tests\Unit\Models;

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnitType\Type;
use App\Containers\OrderSection\Item\Collections\ItemEloquentCollection;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Item\Tests\UnitTestCase;
use App\Containers\OrderSection\Order\Models\Order;
use App\Ship\SimpleTypes\Type\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class ItemTest extends UnitTestCase
{
    protected ?ItemModel $model;

    public function setUp(): void
    {
        parent::setUp();

        $user = $this->getTestingOrganizationUser();

        $this->model = ItemModel::factory()
            ->organization($user->organization_id)
            ->unit()
            ->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(ItemModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(ItemModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertFalse($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(ItemModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Item::ORDER_ID,
            Item::UNIT_ID,
            Item::NAME,
            Item::SKU,
            Item::COST_PRICE,
            Item::CLIENT_PRICE,
            Item::UNIT_CLIENT_PRICE,
            Item::AMOUNT,
            Item::TYPE
        ], $this->model->getFillable());
    }

    public function testCasts(): void
    {
        $this->assertInstanceOf(Type::class, $this->model->type);
        $this->assertInstanceOf(Money::class, $this->model->cost_price);
        $this->assertInstanceOf(Money::class, $this->model->client_price);
        $this->assertInstanceOf(Money::class, $this->model->unit_client_price);
    }

    public function testBelongsToOrder(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->order());
        $this->assertInstanceOf(Order::class, $this->model->order()->getModel());
        $this->assertInstanceOf(Order::class, $this->model->order);
    }

    public function testBelongsUnit(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->unit());
        $this->assertInstanceOf(OrganizationUnit::class, $this->model->unit()->getModel());
        $this->assertInstanceOf(OrganizationUnit::class, $this->model->unit);
    }

    public function testNewCollection(): void
    {
        $this->assertInstanceOf(ItemEloquentCollection::class, $this->model->newCollection());
    }

    public function testGetProfit(): void
    {
        $item = new ItemModel([
            Item::COST_PRICE => 100,
            Item::CLIENT_PRICE => 205,
            Item::AMOUNT => 2
        ]);

        $profit = $item->getProfit();

        $this->assertInstanceOf(Money::class, $profit);
        $this->assertSame(210.0, $profit->val());
    }

    public function testGetTotalClientPrice(): void
    {
        $item = new ItemModel([
            Item::COST_PRICE => 100,
            Item::CLIENT_PRICE => 205,
            Item::AMOUNT => 2
        ]);

        $result = $item->getTotalClientPrice();

        $this->assertInstanceOf(Money::class, $result);
        $this->assertSame(410.0, $result->val());
    }

    public function testIsManualClientPrice(): void
    {
        $itemA = new ItemModel([
            Item::COST_PRICE => 100,
            Item::CLIENT_PRICE => 205,
            Item::UNIT_CLIENT_PRICE => 200,
            Item::AMOUNT => 2
        ]);

        $this->assertTrue($itemA->isManualClientPrice());

        $itemB = new ItemModel([
            Item::COST_PRICE => 100,
            Item::CLIENT_PRICE => 205,
            Item::UNIT_CLIENT_PRICE => 205,
            Item::AMOUNT => 2
        ]);

        $this->assertFalse($itemB->isManualClientPrice());
    }
}
