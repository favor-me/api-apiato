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

use App\Containers\OrderSection\Item\Actions\CreateItemAction;
use App\Containers\OrderSection\Item\Dto\CreateItemDto;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Item\Tests\UnitTestCase;

final class CreateItemActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $data = ItemModel::factory()->make();
        $dto = new CreateItemDto($data->toArray());

        $result = app(CreateItemAction::class)->run($dto);

        $this->assertInstanceOf(ItemModel::class, $result);
    }
}
