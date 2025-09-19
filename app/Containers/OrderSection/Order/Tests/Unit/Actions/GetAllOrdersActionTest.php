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

use App\Containers\OrderSection\Order\Actions\GetAllOrdersAction;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllOrdersActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = OrderModel::factory()
            ->count(10)
            ->create();

        $result = app(GetAllOrdersAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }

    public function testOnlyTrashed(): void
    {
        OrderModel::factory()
            ->count(4)
            ->create();

        OrderModel::factory()
            ->trashed()
            ->create();

        $result = app(GetAllOrdersAction::class)->run(true);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(1, $result->total());
    }
}
