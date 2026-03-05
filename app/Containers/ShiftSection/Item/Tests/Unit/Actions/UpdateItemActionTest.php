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

use App\Containers\ShiftSection\Item\Actions\UpdateItemAction;
use App\Containers\ShiftSection\Item\Dto\UpdateItemDto;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Item\Tests\UnitTestCase;
use App\Containers\ShiftSection\ItemType\AwardType;
use App\Containers\ShiftSection\ItemType\Manager;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateItemActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = ItemModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateItemDto($data->toArray());
        app(UpdateItemAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $model = ItemModel::factory()->create();
        $this->assertInstanceOf(ItemModel::class, $model);

        $awardType = Manager::getInstance()->get(AwardType::class);

        $data = ItemModel::factory()
            ->make([
                ID => $model->id,
                Item::TYPE => $awardType->getName(),
                Item::DESCRIPTION => 'Text'
            ]);

        $dto = new UpdateItemDto($data->toArray());

        $result = app(UpdateItemAction::class)->run($dto);

        $this->assertInstanceOf(ItemModel::class, $result);
        $this->assertInstanceOf(AwardType::class, $result->type);
        $this->assertSame('Text', $result->description);
    }
}
