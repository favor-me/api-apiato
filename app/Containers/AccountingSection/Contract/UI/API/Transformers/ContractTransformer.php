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
use App\Containers\CommunitySection\Counterparty\UI\API\Transformers\CounterpartyTransformer;
use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

class ContractTransformer extends Transformer
{
    protected array $availableIncludes = [
        Contract::ORGANIZATION
    ];

    protected array $defaultIncludes = [
        Contract::COUNTERPARTY
    ];

    public function transform(ContractModel $contract): array
    {
        return [
            OBJECT => $contract->getResourceKey(),
            ID => $contract->getHashedKey(),
            Contract::NAME => $contract->name,
            Contract::NUMBER => $contract->number,
            Contract::COUNTERPARTY_ID => $contract->getHashedKey(Contract::COUNTERPARTY_ID),
            Contract::ORGANIZATION_ID => $contract->getHashedKey(Contract::ORGANIZATION_ID),
            Contract::START_AT => $this->date($contract->start_at),
            Contract::FINISH_AT => $this->date($contract->finish_at),
            Contract::IS_LIVE_NOW => $contract->is_live_now,
            CREATED_AT => $this->time($contract->created_at),
            UPDATED_AT => $this->time($contract->updated_at),
            DELETED_AT => $this->time($contract->deleted_at)
        ];
    }

    protected function includeOrganization(ContractModel $contract): Item
    {
        return $this->item($contract->organization, new OrganizationTransformer());
    }

    protected function includeCounterparty(ContractModel $contract): Item
    {
        return $this->item($contract->counterparty, new CounterpartyTransformer());
    }
}
