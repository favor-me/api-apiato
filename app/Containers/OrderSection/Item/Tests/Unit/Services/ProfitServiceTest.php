<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\OrderSection\Item\Tests\Unit\Services;

use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Item\Services\ProfitService;
use App\Containers\OrderSection\Item\Tests\UnitTestCase;
use App\Ship\SimpleTypes\Type\Money;

final class ProfitServiceTest extends UnitTestCase
{
    public function test(): void
    {
        $result = (new ProfitService(0, 100, 0))->calculate();

        $this->assertInstanceOf(Money::class, $result);
        $this->assertSame(100.0, $result->val());

        $result = (new ProfitService(0, 100, 1))->calculate();
        $this->assertSame(100.0, $result->val());

        $result = (new ProfitService(0, 100, 2))->calculate();
        $this->assertSame(200.0, $result->val());

        $result = (new ProfitService(100, 100, 2))->calculate();
        $this->assertSame(0.0, $result->val());

        $result = (new ProfitService(90, 100, 0))->calculate();
        $this->assertSame(10.0, $result->val());

        $result = (new ProfitService(90, 100, 1))->calculate();
        $this->assertSame(10.0, $result->val());

        $result = (new ProfitService(90, 100, 2))->calculate();
        $this->assertSame(20.0, $result->val());

        $result = (new ProfitService(100, 90, 0))->calculate();
        $this->assertSame(-10.0, $result->val());

        $result = (new ProfitService(100, 90, 1))->calculate();
        $this->assertSame(-10.0, $result->val());

        $result = (new ProfitService(100, 90, 2))->calculate();
        $this->assertSame(-20.0, $result->val());
    }

    public function testFromItem(): void
    {
        $result = (new ProfitService())
            ->fromItem(new ItemModel([
                Item::COST_PRICE => 100,
                Item::CLIENT_PRICE => 200,
                Item::AMOUNT => 1
            ]))
            ->calculate();

        $this->assertInstanceOf(Money::class, $result);
        $this->assertSame(100.0, $result->val());
    }
}
