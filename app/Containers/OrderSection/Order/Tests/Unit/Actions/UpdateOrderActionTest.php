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

use App\Containers\OrderSection\Order\Actions\UpdateOrderAction;
use App\Containers\OrderSection\Order\Dto\UpdateOrderDto;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateOrderActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = OrderModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateOrderDto($data->toArray());
        app(UpdateOrderAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $model = OrderModel::factory()->create();
        $this->assertInstanceOf(OrderModel::class, $model);

        $data = OrderModel::factory()
            ->make([
                ID => $model->id,
                //  write more.
            ]);

        $dto = new UpdateOrderDto($data->toArray());

        $result = app(UpdateOrderAction::class)->run($dto);

        $this->assertInstanceOf(OrderModel::class, $result);
    }
}
