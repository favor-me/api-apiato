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

namespace App\Containers\OrderSection\Item\Tests\Unit\Actions;

use App\Containers\OrderSection\Item\Actions\GetAllItemsAction;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Item\Tests\UnitTestCase;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllItemsActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = ItemModel::factory()
            ->count(10)
            ->create();

        $result = app(GetAllItemsAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }
}
