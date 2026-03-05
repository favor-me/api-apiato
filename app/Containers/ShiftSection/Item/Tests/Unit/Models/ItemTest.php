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

namespace App\Containers\ShiftSection\Item\Tests\Unit\Models;

use App\Containers\AppSection\User\Models\User;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Item\Tests\UnitTestCase;
use App\Containers\ShiftSection\ItemType\Type;
use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Ship\SimpleTypes\Type\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ItemTest extends UnitTestCase
{
    protected ?ItemModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = ItemModel::factory()->make();
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
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(ItemModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Item::SHIFT_ID,
            Item::ORDER_ID,
            Item::TYPE,
            Item::VALUE,
            Item::DESCRIPTION,
            CREATED_BY
        ], $this->model->getFillable());
    }

    public function testCasts(): void
    {
        $this->assertInstanceOf(Type::class, $this->model->type);
        $this->assertInstanceOf(Money::class, $this->model->value);
    }

    public function testBelongsToShift(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->shift());
        $this->assertInstanceOf(Shift::class, $this->model->shift()->getModel());
        $this->assertInstanceOf(Shift::class, $this->model->shift);
    }

    public function testBelongsToCreator(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->creator());
        $this->assertInstanceOf(User::class, $this->model->creator()->getModel());
        $this->assertInstanceOf(User::class, $this->model->creator);
    }

    public function testBelongsToOrder(): void
    {
        $order = Order::factory()->create();

        $model = ItemModel::factory()
            ->make([
                Item::ORDER_ID => $order->id
            ]);

        $this->assertInstanceOf(BelongsTo::class, $model->order());
        $this->assertInstanceOf(Order::class, $model->order()->getModel());
        $this->assertInstanceOf(Order::class, $model->order);
    }
}
