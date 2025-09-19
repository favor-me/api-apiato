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

use App\Containers\OrderSection\Order\Actions\GetTotalOrdersAction;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;

final class GetTotalOrdersActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = OrderModel::factory()
            ->count(8)
            ->create();

        $this->assertTrue(app(GetTotalOrdersAction::class)->run() >= $models->count());
    }
}
