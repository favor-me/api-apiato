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

namespace App\Containers\ShiftSection\Item\Tests\Unit\Actions;

use App\Containers\ShiftSection\Item\Actions\DeleteItemsAction;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Item\Tests\UnitTestCase;

final class DeleteItemsActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $models = ItemModel::factory()
            ->count(2)
            ->create();

        $ids = $models
            ->pluck(ID)
            ->toArray();

        $result = app(DeleteItemsAction::class)->run($ids);

        $this->assertSame($models->count(), $result);
    }
}
