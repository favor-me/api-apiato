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

namespace App\Containers\OrganizationSection\UnitPrice\Tests\Unit\Actions;

use App\Containers\OrganizationSection\UnitPrice\Actions\CreateUnitPriceAction;
use App\Containers\OrganizationSection\UnitPrice\Dto\CreateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;

final class CreateUnitPriceActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $data = UnitPriceModel::factory()->make();
        $dto = new CreateUnitPriceDto($data->toArray());

        $result = app(CreateUnitPriceAction::class)->run($dto);

        $this->assertInstanceOf(UnitPriceModel::class, $result);
    }
}
