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

use App\Containers\AccountingSection\Contract\Actions\GetTotalContractsAction;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\UnitTestCase;

final class GetTotalContractsActionTest extends UnitTestCase
{
    public function test(): void
    {
        $this->getTestingOrganizationUser();

        $models = ContractModel::factory()
            ->count(8)
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $this->assertTrue(app(GetTotalContractsAction::class)->run() >= $models->count());
    }
}
