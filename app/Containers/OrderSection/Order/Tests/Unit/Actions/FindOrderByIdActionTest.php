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

use App\Containers\OrderSection\Order\Actions\FindOrderByIdAction;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindOrderByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->expectException(NotFoundException::class);
        app(FindOrderByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $model = OrderModel::factory()->create();

        $this->assertInstanceOf(
            OrderModel::class,
            app(FindOrderByIdAction::class)->run($model->id)
        );
    }
}
