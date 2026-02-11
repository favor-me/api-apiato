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

use App\Containers\OrganizationSection\Shift\Actions\UpdateShiftAction;
use App\Containers\OrganizationSection\Shift\Dto\UpdateShiftDto;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Containers\OrganizationSection\Shift\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateShiftActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = ShiftModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateShiftDto($data->toArray());
        app(UpdateShiftAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $model = ShiftModel::factory()->create();
        $this->assertInstanceOf(ShiftModel::class, $model);

        $data = ShiftModel::factory()
            ->make([
                ID => $model->id,
                //  write more.
            ]);

        $dto = new UpdateShiftDto($data->toArray());

        $result = app(UpdateShiftAction::class)->run($dto);

        $this->assertInstanceOf(ShiftModel::class, $result);
    }
}
