<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\OrderSection\Order\Tests\Unit\Tasks;

use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tasks\OrderHasStatusTask;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;

final class OrderHasStatusTaskTest extends UnitTestCase
{
    public function test(): void
    {
        $orderA = OrderModel::factory()->create();

        $this->assertFalse(app(OrderHasStatusTask::class)->run($orderA));
        $this->assertFalse(app(OrderHasStatusTask::class)->run($orderA->id));

        $orderB = OrderModel::factory()
            ->canceled()
            ->create();

        $this->assertTrue(app(OrderHasStatusTask::class)->run($orderB->id));
    }
}
