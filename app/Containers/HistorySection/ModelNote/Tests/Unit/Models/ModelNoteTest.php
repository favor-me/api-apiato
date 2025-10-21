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

namespace App\Containers\HistorySection\ModelNote\Tests\Unit\Models;

use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote as ModelNoteModel;
use App\Containers\HistorySection\ModelNote\Tests\UnitTestCase;
use App\Containers\OrderSection\Order\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ModelNoteTest extends UnitTestCase
{
    public function testBelongsToEvent(): void
    {
        $order = Order::factory()->create();

        $modelNote = ModelNoteModel::factory()
            ->model($order)
            ->create([
                ModelNote::TYPE => 'plus_organization_unit_balance'
            ]);

        $this->assertInstanceOf(BelongsTo::class, $modelNote->event());
        $this->assertInstanceOf(ModelEvent::class, $modelNote->event()->getModel());
        $this->assertInstanceOf(ModelEvent::class, $modelNote->event);
    }
}
