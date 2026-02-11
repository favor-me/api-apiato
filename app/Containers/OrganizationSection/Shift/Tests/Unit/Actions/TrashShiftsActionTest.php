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

use App\Containers\OrganizationSection\Shift\Actions\TrashShiftsAction;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Containers\OrganizationSection\Shift\Tests\UnitTestCase;

final class TrashShiftsActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $models = ShiftModel::factory()
            ->count(10)
            ->create();

        $ids = $models->pluck(ID);

        $result = app(TrashShiftsAction::class)->run($ids->toArray());

        $this->assertSame($models->count(), $result);

        $models
            ->each(function (ShiftModel $model) {
                $model->refresh();
                $this->assertSoftDeleted(ShiftModel::TABLE, [ID => $model->id]);
            });
    }
}
