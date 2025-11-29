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

use App\Containers\OrganizationSection\UnitPrice\Actions\UpdateUnitPriceAction;
use App\Containers\OrganizationSection\UnitPrice\Dto\UpdateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateUnitPriceActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->getTestingOrganizationUser();

        $this->expectException(UpdateResourceFailedException::class);
        $data = UnitPriceModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateUnitPriceDto($data->toArray());
        app(UpdateUnitPriceAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationUser();

        $model = UnitPriceModel::factory()->create();
        $this->assertInstanceOf(UnitPriceModel::class, $model);

        $data = UnitPriceModel::factory()
            ->make([
                ID => $model->id,
                UnitPrice::COST_PRICE => 132000
            ]);

        $dto = new UpdateUnitPriceDto($data->toArray());

        $result = app(UpdateUnitPriceAction::class)->run($dto);

        $this->assertInstanceOf(UnitPriceModel::class, $result);
        $this->assertSame(1320.0, $result->cost_price->currency()->val());
    }
}
