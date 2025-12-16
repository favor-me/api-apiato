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
use App\Containers\AppSection\User\Traits\IsOrganizationOwner;
use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Counterparty\Dto\CreateCounterpartyDto;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Counterparty\Requests\CounterpartyApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Utils\Str;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use ReflectionException;

class CreateCounterpartyRequest extends CounterpartyApiRequest implements GettableDto
{
    use IsOrganizationOwner;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected array $countryMessages = [];

    /**
     * @return array
     * @throws ReflectionException
     */
    public function rules(): array
    {
        $rules = [
            Counterparty::NAME => $this->getCounterpartyNameValidationRules(),
            Counterparty::OWNERSHIP_TYPE => $this->getOrganizationOwnershipTypeValidationRules(),
            Counterparty::LEGAL_ADDRESS => $this->getCounterpartyAddressValidationRules(),
            Counterparty::MAILING_ADDRESS => $this->getCounterpartyMailingAddressValidationRules(),
            Counterparty::PHONE_NUMBER => $this->getCounterpartyPhoneNumberValidationRules(),
            Counterparty::EMAIL => $this->getCounterpartyEmailValidationRules(),
            Counterparty::COUNTRY => $this->getCounterpartyCountryValidationRules(),
            Counterparty::BANK_DATA => $this->getCounterpartyBankDataValidationRules(),
            Counterparty::ORGANIZATION_ID => $this->getCounterpartyOrganizationIdValidationRules(),
        ];

        $country = Manager::getInstance()
            ->get(
                (string)$this->get(Counterparty::COUNTRY)
            );

        if (!is_null($country)) {
            $schema = $country
                ->setOwnershipType($this->get(Counterparty::OWNERSHIP_TYPE))
                ->getBankDataSchema();

            $rules = array_merge($rules, $schema->getRules());
            $this->countryMessages = $schema->getValidationMessages();
        }

        return $rules;
    }

    public function messages(): array
    {
        return array_merge([
            Counterparty::NAME . '.unique' => Container::trans(
                'container.validation.name.unique'
            ),
            Counterparty::OWNERSHIP_TYPE . '.required' => Container::trans(
                'container.validation.ownership_type.required'
            ),
            Counterparty::LEGAL_ADDRESS . '.required' => Container::trans(
                'container.validation.legal_address.required'
            ),
            Counterparty::MAILING_ADDRESS . '.required' => Container::trans(
                'container.validation.mailing_address.required'
            ),
        ], $this->countryMessages);
    }

    public function getOrganizationOwnershipTypeValidationRules(): ValidationRules
    {
        return parent::getOrganizationOwnershipTypeValidationRules()
            ->addRequired();
    }

    public function getCounterpartyMailingAddressValidationRules(): ValidationRules
    {
        return parent::getCounterpartyMailingAddressValidationRules()
            ->addRequired();
    }

    public function getCounterpartyNameValidationRules(): ValidationRules
    {
        return parent::getCounterpartyNameValidationRules()
            ->add(
                $this->getCounterpartyNameUniqueValidationRules()
            )
            ->addRequired();
    }

    protected function getCounterpartyNameUniqueValidationRules(): Unique
    {
        return Rule::unique(CounterpartyModel::TABLE)
            ->where(Counterparty::ORGANIZATION_ID, $this->organization_id);
    }

    public function getCounterpartyAddressValidationRules(): ValidationRules
    {
        return parent::getCounterpartyLegalAddressValidationRules()
            ->addRequired();
    }

    public function getCounterpartyPhoneNumberValidationRules(): ValidationRules
    {
        return parent::getCounterpartyPhoneNumberValidationRules()
            ->addRequired();
    }

    public function getCounterpartyCountryValidationRules(): ValidationRules
    {
        return parent::getCounterpartyCountryValidationRules()
            ->addRequired();
    }

    public function getCounterpartyOrganizationIdValidationRules(): ValidationRules
    {
        return $this->getOrganizationIdValidationRules()
            ->addRequired();
    }

    /**
     * @return CreateCounterpartyDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateCounterpartyDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateCounterpartyDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateCounterpartyDto
    {
        return new CreateCounterpartyDto($data);
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->prepareForValidationPhoneNumber();
    }

    protected function prepareForValidationPhoneNumber(): void
    {
        if ($this->has(Counterparty::PHONE_NUMBER)) {
            $this->merge([
                Counterparty::PHONE_NUMBER => Str::toPhoneNumber(
                    $this->get(Counterparty::PHONE_NUMBER)
                )
            ]);
        }
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }
}
