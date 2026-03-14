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

use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
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

        $contract = ContractModel::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        $unit = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        $model = UnitPriceModel::factory()
            ->create([
                UnitPrice::MODEL_ID => $contract->id,
                UnitPrice::UNIT_ID => $unit->id
            ]);

        $this->assertInstanceOf(UnitPriceModel::class, $model);

        $data = [
            ID => $model->id,
            UnitPrice::COST_PRICE => 132000,
            UnitPrice::UNIT_ID => $unit->id
        ];

        $dto = new UpdateUnitPriceDto($data);

        $result = app(UpdateUnitPriceAction::class)->run($dto);

        $this->assertInstanceOf(OrganizationUnitModel::class, $result);
        $this->assertSame(1320.0, $result->cost_price->currency()->val());
    }
}
