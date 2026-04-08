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

use App\Containers\ShiftSection\Shift\Actions\ConfirmShiftsAction;
use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Containers\ShiftSection\Shift\Tests\UnitTestCase;
use Illuminate\Support\Carbon;

class ConfirmShiftsActionTest extends UnitTestCase
{
    public function test(): void
    {
        $shift = Shift::factory()->create();

        $result = app(ConfirmShiftsAction::class)->run([$shift->id]);

        $this->assertSame(1, $result);

        $shift->refresh();

        $this->assertInstanceOf(Carbon::class, $shift->confirmed_at);
    }
}
