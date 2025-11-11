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

use App\Containers\CommunitySection\Counterparty\Actions\UpdateCounterpartyAction;
use App\Containers\CommunitySection\Counterparty\Dto\UpdateCounterpartyDto;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateCounterpartyActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = CounterpartyModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateCounterpartyDto($data->toArray());
        app(UpdateCounterpartyAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $model = CounterpartyModel::factory()->create();
        $this->assertInstanceOf(CounterpartyModel::class, $model);

        $data = CounterpartyModel::factory()
            ->make([
                ID => $model->id,
                Counterparty::NAME => 'New name'
            ]);

        $dto = new UpdateCounterpartyDto($data->toArray());

        $result = app(UpdateCounterpartyAction::class)->run($dto);

        $this->assertInstanceOf(CounterpartyModel::class, $result);
        $this->assertSame($data->name, $result->name);
    }
}
