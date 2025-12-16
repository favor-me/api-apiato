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

namespace App\Containers\CommunitySection\Organization\UI\API\Requests;

use App\Containers\CommunitySection\Counterparty\Countries\Country;
use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Counterparty\Countries\Manager as CountryManager;
use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Organization\Dto\CreateOrganizationDto;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use App\Containers\CommunitySection\Organization\Requests\OrganizationApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Utils\Str;
use ReflectionException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrganizationRequest extends OrganizationApiRequest implements GettableDto
{
    protected array $access = [
        PERMISSIONS => Permissions::CREATE
    ];

    protected array $countryMessages = [];

    protected array $decode = [
        Organization::USER_OWNER_ID
    ];

    /**
     * @return array
     * @throws ReflectionException
     */
    public function rules(): array
    {
        $rules = [
            Organization::NAME => $this->getOrganizationNameValidationRules(),
            Organization::EMAIL => $this->getOrganizationEmailValidationRules(),
            Organization::COUNTRY => $this->getOrganizationCountryValidationRules(),
            Organization::BANK_DATA => $this->getOrganizationBankDataValidationRules(),
            Organization::PHONE_NUMBER => $this->getOrganizationPhoneNumberValidationRules(),
            Organization::USER_OWNER_ID => $this->getOrganizationUserOwnerIdValidationRules(),
            Organization::OWNERSHIP_TYPE => $this->getOrganizationOwnershipTypeValidationRules()
        ];

        $country = Manager::getInstance()
            ->get(
                (string)$this->get(Organization::COUNTRY)
            );

        if (!is_null($country)) {
            $schema = $country
                ->setOwnershipType($this->get(Organization::OWNERSHIP_TYPE))
                ->getBankDataSchema();

            $rules = array_merge($rules, $schema->getRules());
            $this->countryMessages = $schema->getValidationMessages();
        }

        return $rules;
    }

    public function getOrganizationOwnershipTypeValidationRules(): ValidationRules
    {
        return parent::getOrganizationOwnershipTypeValidationRules()
            ->addRequired();
    }

    public function getOrganizationCountryValidationRules(): ValidationRules
    {
        return parent::getOrganizationCountryValidationRules()
            ->addRequired();
    }

    public function getOrganizationUserOwnerIdValidationRules(): ValidationRules
    {
        return $this->getUserIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationNameValidationRules(): ValidationRules
    {
        return parent::getOrganizationNameValidationRules()
            ->addRequired();
    }

    public function getOrganizationPhoneNumberValidationRules(): ValidationRules
    {
        return parent::getOrganizationPhoneNumberValidationRules()
            ->addRequired();
    }

    /**
     * @return CreateOrganizationDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateOrganizationDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateOrganizationDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateOrganizationDto
    {
        return new CreateOrganizationDto($data);
    }

    public function messages(): array
    {
        return parent::messages() + $this->countryMessages +
            [
                Organization::NAME . '.required' => Container::trans('validation.name.required'),
                Organization::NAME . '.unique' => Container::trans('validation.name.unique'),
                Organization::COUNTRY . '.required' => Container::trans('validation.country.required'),
                Organization::OWNERSHIP_TYPE . '.required' => Container::trans('validation.ownership_type.required'),
                Organization::PHONE_NUMBER . '.required' => Container::trans('validation.phone_number.required')
            ];
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationCountry();
        $this->prepareForValidationPhoneNumber();
    }

    protected function prepareForValidationCountry(): void
    {
        $country = $this->defaultCountry();
        $countryInput = $this->get(Organization::COUNTRY, $country->getName());

        if (empty($countryInput)) {
            $countryInput = $country->getName();
        }

        $this->merge([
            Organization::COUNTRY => $countryInput
        ]);
    }

    protected function prepareForValidationPhoneNumber(): void
    {
        if ($this->has(Organization::PHONE_NUMBER)) {
            $this->merge([
                Organization::PHONE_NUMBER => Str::toPhoneNumber($this->get(Organization::PHONE_NUMBER))
            ]);
        }
    }

    protected function defaultCountry(): Country
    {
        return CountryManager::getInstance()->get(RuCountry::class);
    }
}
