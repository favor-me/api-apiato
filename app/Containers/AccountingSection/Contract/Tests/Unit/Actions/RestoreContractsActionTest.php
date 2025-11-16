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

use App\Containers\AccountingSection\Contract\Actions\RestoreContractsAction;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\UnitTestCase;
use Illuminate\Support\Carbon;

final class RestoreContractsActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $this->getTestingOrganizationUser();

        $model = ContractModel::factory()
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $this->assertSame(ZERO, app(RestoreContractsAction::class)->run([$model->id]));
    }

    public function testTrashed(): void
    {
        $this->getTestingOrganizationUser();

        $model = ContractModel::factory()
            ->trashed()
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $this->assertInstanceOf(Carbon::class, $model->deleted_at);

        $this->assertSame(1, app(RestoreContractsAction::class)->run([$model->id]));

        $model->refresh();

        $this->assertNull($model->deleted_at);
    }
}
