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

namespace App\Containers\AccountingSection\Contract\Tests\Unit\Actions;

use App\Containers\AccountingSection\Contract\Actions\CreateContractAction;
use App\Containers\AccountingSection\Contract\Dto\CreateContractDto;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\UnitTestCase;

final class CreateContractActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $this->getTestingOrganizationUser();

        $data = ContractModel::factory()
            ->counterparty($this->testingUser->organization_id)
            ->make();

        $dto = new CreateContractDto($data->toArray());

        $result = app(CreateContractAction::class)->run($dto);

        $this->assertInstanceOf(ContractModel::class, $result);
    }
}
