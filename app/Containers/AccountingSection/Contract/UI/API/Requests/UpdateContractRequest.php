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

use App\Containers\AccountingSection\Contract\Dto\UpdateContractDto;
use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Exists;

/**
 * @method UpdateContractDto getDto()
 */
class UpdateContractRequest extends CreateContractRequest
{
    use HasInputId;

    protected array $urlParameters = [
        ID
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(ID);
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ID => $this->getContractIdValidationRules()
        ]);
    }

    public function getContractIdValidationRules(): ValidationRules
    {
        return parent::getContractIdValidationRules()
            ->addRequired();
    }

    public function getContractNameValidationRules(): ValidationRules
    {
        return parent::getContractNameValidationRules()
            ->removeRequired();
    }

    public function getCounterpartyIdValidationRules(): ValidationRules
    {
        return parent::getCounterpartyIdValidationRules()
            ->removeRequired();
    }

    public function getOrganizationIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationIdValidationRules()
            ->removeRequired();
    }

    public function getContractStartAtValidationRules(): ValidationRules
    {
        return parent::getContractStartAtValidationRules()
            ->removeRequired();
    }

    public function getContractFinishAtValidationRules(): ValidationRules
    {
        return parent::getContractFinishAtValidationRules()
            ->removeRequired();
    }

    public function getContractIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getContractIdExistsValidationRule($column)
            ->where(Contract::ORGANIZATION_ID, $this->organization_id);
    }

    public function newDto(array $data = []): UpdateContractDto
    {
        return new UpdateContractDto($data);
    }

    /**
     * @return bool
     * @throws ValidationFailedException
     * @throws AuthorizationException
     */
    protected function passesAuthorization(): bool
    {
        $result = parent::passesAuthorization();
        if ($result === true) {
            $this->throwIfEmptyInput();
        }

        return $result;
    }
}
