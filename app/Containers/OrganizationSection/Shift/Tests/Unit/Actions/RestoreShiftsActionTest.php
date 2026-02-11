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

namespace App\Containers\OrganizationSection\Shift\Tests\Unit\Actions;

use App\Containers\OrganizationSection\Shift\Actions\RestoreShiftsAction;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Containers\OrganizationSection\Shift\Tests\UnitTestCase;
use Illuminate\Support\Carbon;

final class RestoreShiftsActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = ShiftModel::factory()->create();
        $this->assertSame(ZERO, app(RestoreShiftsAction::class)->run([$model->id]));
    }

    public function testTrashed(): void
    {
        $model = ShiftModel::factory()
            ->trashed()
            ->create();

        $this->assertInstanceOf(Carbon::class, $model->deleted_at);

        $this->assertSame(1, app(RestoreShiftsAction::class)->run([$model->id]));

        $model->refresh();

        $this->assertNull($model->deleted_at);
    }
}
