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

namespace App\Containers\ShiftSection\Shift\Tests\Unit\Actions;

use App\Containers\ShiftSection\Shift\Actions\FindShiftByIdAction;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindShiftByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->expectException(NotFoundException::class);
        app(FindShiftByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $model = ShiftModel::factory()->create();

        $this->assertInstanceOf(
            ShiftModel::class,
            app(FindShiftByIdAction::class)->run($model->id)
        );
    }
}
