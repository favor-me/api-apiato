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

namespace App\Containers\AccountingSection\Contract\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AccountingSection\Contract\Dto\CreateContractDto;
use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Requests\ContractApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Support\Carbon;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateContractRequest extends ContractApiRequest implements GettableDto
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(Contract::COUNTERPARTY_ID);
    }

    public function rules(): array
    {
        return [
            Contract::NAME => $this->getContractNameValidationRules(),
            Contract::COUNTERPARTY_ID => $this->getCounterpartyIdValidationRules(),
            Contract::ORGANIZATION_ID => $this->getOrganizationIdValidationRules(),
            Contract::START_AT => $this->getContractStartAtValidationRules(),
            Contract::FINISH_AT => $this->getContractFinishAtValidationRules(),
        ];
    }

    public function getContractNameValidationRules(): ValidationRules
    {
        return parent::getContractNameValidationRules()
            ->addRequired();
    }

    public function getCounterpartyIdValidationRules(): ValidationRules
    {
        return parent::getCounterpartyIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationIdValidationRules()
            ->addRequired();
    }

    public function getContractStartAtValidationRules(): ValidationRules
    {
        return parent::getContractStartAtValidationRules()
            ->addRequired();
    }

    public function getContractFinishAtValidationRules(): ValidationRules
    {
        $rules = parent::getContractFinishAtValidationRules();

        if (is_null($this->get(Contract::FINISH_AT))) {
            return $rules;
        }

        $startAt = $this->get(Contract::START_AT);
        if (!is_null($startAt) && Carbon::isSystemDateFormat($startAt)) {
            $rules->add('after:' . $startAt);
        }

        return $rules;
    }

    /**
     * @return CreateContractDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateContractDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateContractDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateContractDto
    {
        return new CreateContractDto($data);
    }
}
