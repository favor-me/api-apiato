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

namespace App\Containers\CommunitySection\Counterparty\Actions;

use App\Containers\CommunitySection\Counterparty\Tasks\GetCounterpartyBankDataSchemaTask;
use App\Ship\Parents\Actions\Action;

class GetCounterpartyBankDataSchemaAction extends Action
{
    public function run(string $country, bool $testData = false): ?array
    {
        return app(GetCounterpartyBankDataSchemaTask::class)->run($country, $testData);
    }
}
