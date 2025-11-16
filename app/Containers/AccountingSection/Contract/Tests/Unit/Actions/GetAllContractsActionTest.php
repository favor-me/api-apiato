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

use App\Containers\AccountingSection\Contract\Actions\GetAllContractsAction;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\UnitTestCase;
use App\Containers\CommunitySection\Organization\Models\Organization;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllContractsActionTest extends UnitTestCase
{
    public function test(): void
    {
        $this->getTestingOrganizationUser();

        ContractModel::factory()
            ->count(2)
            ->counterparty(
                Organization::factory()->create()->id
            )
            ->create();

        $models = ContractModel::factory()
            ->count(4)
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $result = app(GetAllContractsAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }

    public function testOnlyTrashed(): void
    {
        $this->getTestingOrganizationUser();

        ContractModel::factory()
            ->count(4)
            ->counterparty($this->testingUser->organization_id)
            ->create();

        ContractModel::factory()
            ->trashed()
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $result = app(GetAllContractsAction::class)->run(true);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(1, $result->total());
    }
}
