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

namespace App\Containers\CommunitySection\Counterparty\Tests\Unit\Actions;

use App\Containers\CommunitySection\Counterparty\Actions\TrashCounterpartiesAction;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;

final class TrashCounterpartiesActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $models = CounterpartyModel::factory()
            ->count(10)
            ->create();

        $ids = $models->pluck(ID);

        $result = app(TrashCounterpartiesAction::class)->run($ids->toArray());

        $this->assertSame($models->count(), $result);

        $models
            ->each(function (CounterpartyModel $model) {
                $model->refresh();
                $this->assertSoftDeleted(CounterpartyModel::TABLE, [ID => $model->id]);
            });
    }
}
