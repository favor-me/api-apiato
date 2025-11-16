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

namespace App\Containers\AccountingSection\Contract\UI\API\Transformers;

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;

class AdminContractTransformer extends ContractTransformer
{
    public function transform(ContractModel $contract): array
    {
        return parent::transform($contract) +
            [
                $this->realKey(ID) => $contract->id,
                $this->realKey(Contract::COUNTERPARTY_ID) => $contract->counterparty_id,
                $this->realKey(Contract::ORGANIZATION_ID) => $contract->organization_id
            ];
    }
}
