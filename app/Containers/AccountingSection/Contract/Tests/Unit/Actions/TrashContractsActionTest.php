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

use App\Containers\AccountingSection\Contract\Actions\TrashContractsAction;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\UnitTestCase;

final class TrashContractsActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $this->getTestingOrganizationUser();

        $models = ContractModel::factory()
            ->count(10)
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $ids = $models->pluck(ID);

        $result = app(TrashContractsAction::class)->run($ids->toArray());

        $this->assertSame($models->count(), $result);

        $models
            ->each(function (ContractModel $model) {
                $model->refresh();
                $this->assertSoftDeleted(ContractModel::TABLE, [ID => $model->id]);
            });
    }
}
