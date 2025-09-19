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

use App\Containers\OrderSection\Order\Actions\TrashOrdersAction;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;

final class TrashOrdersActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $models = OrderModel::factory()
            ->count(10)
            ->create();

        $ids = $models->pluck(ID);

        $result = app(TrashOrdersAction::class)->run($ids->toArray());

        $this->assertSame($models->count(), $result);

        $models
            ->each(function (OrderModel $model) {
                $model->refresh();
                $this->assertSoftDeleted(OrderModel::TABLE, [ID => $model->id]);
            });
    }
}
