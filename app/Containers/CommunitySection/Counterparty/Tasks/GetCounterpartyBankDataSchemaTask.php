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
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use JBZoo\Data\JSON;
use ReflectionException;

class GetCounterpartyBankDataSchemaTask extends CounterpartyTask
{
    /**
     * @param string $country
     * @param string $ownershipType
     * @param bool $testData
     * @return array|null
     * @throws ReflectionException
     */
    public function run(string $country, string $ownershipType, bool $testData = false): ?array
    {
        $countryObj = Manager::getInstance()->get($country);

        if (is_null($countryObj)) {
            return null;
        }

        return $countryObj
            ->setOwnershipType($ownershipType)
            ->getBankDataSchema(
                $this->getTestBankData($testData)
            )
            ->toSchema();
    }

    protected function getTestBankData(bool $testData = false): ?JSON
    {
        if ($testData) {
            return Counterparty::factory()
                ->rus()
                ->make()
                ->bank_data;
        }

        return null;
    }
}
