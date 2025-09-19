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

use App\Containers\OrderSection\Order\Actions\RestoreOrdersAction;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;
use Illuminate\Support\Carbon;

final class RestoreOrdersActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = OrderModel::factory()->create();
        $this->assertSame(ZERO, app(RestoreOrdersAction::class)->run([$model->id]));
    }

    public function testTrashed(): void
    {
        $model = OrderModel::factory()
            ->trashed()
            ->create();

        $this->assertInstanceOf(Carbon::class, $model->deleted_at);

        $this->assertSame(1, app(RestoreOrdersAction::class)->run([$model->id]));

        $model->refresh();

        $this->assertNull($model->deleted_at);
    }
}
