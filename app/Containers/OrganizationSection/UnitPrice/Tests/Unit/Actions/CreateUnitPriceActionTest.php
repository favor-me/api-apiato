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
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\OrganizationSection\UnitPrice\Actions\CreateUnitPriceAction;
use App\Containers\OrganizationSection\UnitPrice\Dto\CreateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;

final class CreateUnitPriceActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $this->getTestingOrganizationUser();

        $contract = ContractModel::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        $data = UnitPriceModel::factory()
            ->make([
                UnitPrice::MODEL_ID => $contract->id
            ]);

        $dto = new CreateUnitPriceDto($data->toArray());

        $result = app(CreateUnitPriceAction::class)->run($dto);

        $this->assertInstanceOf(OrganizationUnit::class, $result);
    }
}
