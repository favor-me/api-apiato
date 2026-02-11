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

use App\Containers\OrganizationSection\Shift\Actions\CreateShiftAction;
use App\Containers\OrganizationSection\Shift\Dto\CreateShiftDto;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Containers\OrganizationSection\Shift\Tests\UnitTestCase;

final class CreateShiftActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $data = ShiftModel::factory()->make();
        $dto = new CreateShiftDto($data->toArray());

        $result = app(CreateShiftAction::class)->run($dto);

        $this->assertInstanceOf(ShiftModel::class, $result);
    }
}
