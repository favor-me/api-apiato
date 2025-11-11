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

use App\Containers\CommunitySection\Counterparty\Actions\DeleteCounterpartiesAction;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;

final class DeleteCounterpartiesActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = CounterpartyModel::factory()->create();

        $result = app(DeleteCounterpartiesAction::class)->run([$model->id]);

        $this->assertSame(ZERO, $result);
    }

    public function testTrashed(): void
    {
        $models = CounterpartyModel::factory()
            ->count(2)
            ->trashed()
            ->create();

        $ids = $models
            ->pluck(ID)
            ->toArray();

        $result = app(DeleteCounterpartiesAction::class)->run($ids);

        $this->assertSame($models->count(), $result);
    }
}
