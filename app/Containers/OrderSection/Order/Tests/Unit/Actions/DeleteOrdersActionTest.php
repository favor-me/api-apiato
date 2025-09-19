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

use App\Containers\OrderSection\Order\Actions\DeleteOrdersAction;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;

final class DeleteOrdersActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = OrderModel::factory()->create();

        $result = app(DeleteOrdersAction::class)->run([$model->id]);

        $this->assertSame(ZERO, $result);
    }

    public function testTrashed(): void
    {
        $models = OrderModel::factory()
            ->count(2)
            ->trashed()
            ->create();

        $ids = $models
            ->pluck(ID)
            ->toArray();

        $result = app(DeleteOrdersAction::class)->run($ids);

        $this->assertSame($models->count(), $result);
    }
}
