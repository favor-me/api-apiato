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

namespace App\Containers\CommunitySection\Counterparty\Tasks;

use App\Containers\CommunitySection\Counterparty\Countries\Manager;

class GetCounterpartyBankDataSchemaTask extends CounterpartyTask
{
    public function run(string $country): ?array
    {
        $countryObj = Manager::getInstance()->get($country);
        if (!is_null($countryObj)) {
            return $countryObj
                ->getBankDataSchema()
                ->toSchema();
        }

        return null;
    }
}
