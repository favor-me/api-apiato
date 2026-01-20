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

namespace App\Containers\CommunitySection\Counterparty\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\Counterparty\Countries\Country;
use App\Containers\CommunitySection\Counterparty\Dto\UpdateCounterpartyDto;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Counterparty\Tasks\FindCounterpartyByIdTask;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use JBZoo\Data\JSON;

/**
 * @method UpdateCounterpartyDto getDto()
 */
class UpdateCounterpartyRequest extends CreateCounterpartyRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected array $urlParameters = [
        ID
    ];

    protected function afterInitialize(): void
    {
        $this->mergeDecode(ID);
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ID => $this->getCounterpartyIdValidationRules()
        ]);
    }

    public function getCounterpartyIdValidationRules(): ValidationRules
    {
        return parent::getCounterpartyIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationOwnershipTypeValidationRules(): ValidationRules
    {
        return parent::getOrganizationOwnershipTypeValidationRules()
            ->removeRequired();
    }

    public function getCounterpartyMailingAddressValidationRules(): ValidationRules
    {
        return parent::getCounterpartyMailingAddressValidationRules()
            ->removeRequired();
    }

    public function getCounterpartyNameValidationRules(): ValidationRules
    {
        return parent::getCounterpartyNameValidationRules()
            ->removeRequired();
    }

    protected function getCounterpartyNameUniqueValidationRules(): Unique
    {
        return parent::getCounterpartyNameUniqueValidationRules()
            ->ignore($this->id);
    }

    public function getCounterpartyAddressValidationRules(): ValidationRules
    {
        return parent::getCounterpartyLegalAddressValidationRules()
            ->removeRequired();
    }

    public function getCounterpartyPhoneNumberValidationRules(): ValidationRules
    {
        return parent::getCounterpartyPhoneNumberValidationRules()
            ->removeRequired();
    }

    public function getCounterpartyCountryValidationRules(): ValidationRules
    {
        return parent::getCounterpartyCountryValidationRules()
            ->removeRequired();
    }

    public function getCounterpartyOrganizationIdValidationRules(): ValidationRules
    {
        return $this->getOrganizationIdValidationRules()
            ->removeRequired();
    }

    public function newDto(array $data = []): UpdateCounterpartyDto
    {
        return new UpdateCounterpartyDto($data);
    }

    public function getCounterpartyIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getCounterpartyIdExistsValidationRule($column)
            ->where(Counterparty::ORGANIZATION_ID, $this->organization_id);
    }

    protected function getFindBankDataModel(): ?CounterpartyModel
    {
        if (is_null($this->id)) {
            return null;
        }

        try {
            return app(FindCounterpartyByIdTask::class)->run($this->id);
        } catch (NotFoundException) {
            return null;
        }
    }

    protected function getBankData(): ?JSON
    {
        return new JSON($this->bank_data);
    }

    protected function getCountry(): ?Country
    {
        $country = parent::getCountry();

        if (!is_null($country)) {
            return $country
                ->setContext(CounterpartyModel::class)
                ->setIgnoreValue($this->id);
        }

        return null;
    }

    /**
     * @return void
     * @throws NotFoundException
     */
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->prepareForValidationBankData();
    }

    /**
     * @return bool
     * @throws AuthorizationException
     * @throws ValidationFailedException
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
