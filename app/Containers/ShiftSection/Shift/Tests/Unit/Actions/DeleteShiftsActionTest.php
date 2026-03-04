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

use App\Containers\ShiftSection\Shift\Actions\DeleteShiftsAction;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\UnitTestCase;

final class DeleteShiftsActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = ShiftModel::factory()->create();

        $result = app(DeleteShiftsAction::class)->run([$model->id]);

        $this->assertSame(1, $result);
    }
}
