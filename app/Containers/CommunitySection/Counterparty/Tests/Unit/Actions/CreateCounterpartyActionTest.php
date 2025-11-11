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

use App\Containers\CommunitySection\Counterparty\Actions\CreateCounterpartyAction;
use App\Containers\CommunitySection\Counterparty\Dto\CreateCounterpartyDto;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;

final class CreateCounterpartyActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $data = CounterpartyModel::factory()->make();
        $dto = new CreateCounterpartyDto($data->toArray());

        $result = app(CreateCounterpartyAction::class)->run($dto);

        $this->assertInstanceOf(CounterpartyModel::class, $result);
    }
}
