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

use App\Containers\AccountingSection\Contract\Actions\UpdateContractAction;
use App\Containers\AccountingSection\Contract\Dto\UpdateContractDto;
use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateContractActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->getTestingOrganizationUser();

        $this->expectException(UpdateResourceFailedException::class);

        $data = ContractModel::factory()
            ->counterparty($this->testingUser->organization_id)
            ->make([
                ID => 123123,
            ]);

        $dto = new UpdateContractDto($data->toArray());
        app(UpdateContractAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationUser();

        $model = ContractModel::factory()
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $this->assertInstanceOf(ContractModel::class, $model);

        $dto = new UpdateContractDto([
            ID => $model->id,
            Contract::NAME => 'New Name'
        ]);

        $result = app(UpdateContractAction::class)->run($dto);

        $this->assertInstanceOf(ContractModel::class, $result);
        $this->assertSame($dto->name, $result->name);
    }
}
