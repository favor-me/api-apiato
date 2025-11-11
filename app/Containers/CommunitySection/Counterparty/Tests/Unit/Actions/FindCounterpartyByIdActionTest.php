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

use App\Containers\CommunitySection\Counterparty\Actions\FindCounterpartyByIdAction;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindCounterpartyByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->expectException(NotFoundException::class);
        app(FindCounterpartyByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $model = CounterpartyModel::factory()->create();

        $this->assertInstanceOf(
            CounterpartyModel::class,
            app(FindCounterpartyByIdAction::class)->run($model->id)
        );
    }
}
