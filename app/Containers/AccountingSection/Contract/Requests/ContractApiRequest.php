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

namespace App\Containers\AccountingSection\Contract\Requests;

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Traits\ContractValidationRules;
use App\Containers\AccountingSection\Contract\UI\API\Transformers\AdminContractTransformer;
use App\Containers\AccountingSection\Contract\UI\API\Transformers\ContractTransformer;
use App\Containers\AppSection\User\Traits\IsOrganizationUser;
use App\Containers\CommunitySection\Counterparty\Traits\CounterpartyValidationRules;
use App\Containers\CommunitySection\Organization\Traits\OrganizationValidationRules;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;
use Illuminate\Validation\Rules\Exists;

/**
 * @property-read mixed $organization_id
 */
abstract class ContractApiRequest extends ApiRequest implements GettableTransformer
{
    use IsOrganizationUser;
    use ContractValidationRules;

    use CounterpartyValidationRules {
        getCounterpartyIdExistsValidationRule as getBaseCounterpartyIdExistsValidationRule;
    }

    use OrganizationValidationRules {
        getOrganizationIdExistsValidationRule as getBaseOrganizationIdExistsValidationRule;
    }

    protected array $decode = [
        Contract::ORGANIZATION_ID
    ];

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminContractTransformer() : new ContractTransformer();
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationOrganizationId();
    }

    public function getCounterpartyIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return $this->getBaseCounterpartyIdExistsValidationRule($column)
            ->where(Contract::ORGANIZATION_ID, $this->organization_id);
    }

    protected function prepareForValidationOrganizationId(): void
    {
        if (!is_null($this->user())) {
            $this->merge([
                Contract::ORGANIZATION_ID => $this->user()->getHashedKey(Contract::ORGANIZATION_ID)
            ]);
        }
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationUser'
        ]);
    }
}
