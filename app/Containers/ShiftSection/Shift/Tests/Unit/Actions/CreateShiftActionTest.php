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

use App\Containers\ShiftSection\Shift\Actions\CreateShiftAction;
use App\Containers\ShiftSection\Shift\Dto\CreateShiftDto;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\UnitTestCase;

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
