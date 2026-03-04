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

use App\Containers\ShiftSection\Shift\Actions\GetAllShiftsAction;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\UnitTestCase;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllShiftsActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = ShiftModel::factory()
            ->count(10)
            ->create();

        $result = app(GetAllShiftsAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }
}
