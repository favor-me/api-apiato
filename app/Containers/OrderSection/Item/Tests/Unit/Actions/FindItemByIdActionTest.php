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

use App\Containers\OrderSection\Item\Actions\FindItemByIdAction;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Item\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindItemByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->expectException(NotFoundException::class);
        app(FindItemByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $model = ItemModel::factory()->create();

        $this->assertInstanceOf(
            ItemModel::class,
            app(FindItemByIdAction::class)->run($model->id)
        );
    }
}
