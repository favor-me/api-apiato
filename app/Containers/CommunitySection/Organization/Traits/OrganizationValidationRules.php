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

namespace App\Containers\CommunitySection\Organization\Traits;

use App\Containers\CommunitySection\Counterparty\Validation\Rules\ExistsCounterpartyCountryRule;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\OrganizationSection\OwnershipType\Validation\Rules\ExistsOwnershipTypeRule;
use App\Ship\Traits\Validation\HasParamsValidationRules;
use App\Ship\Validation\Rules\PhoneNumber as PhoneNumberValidationRule;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Support\PhoneNumber;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\Rules\Exists;

trait OrganizationValidationRules
{
    use HasParamsValidationRules;

    public function getOrganizationIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getOrganizationIdExistsValidationRule(ID)
        ]);
    }

    public function getOrganizationNameValidationRules(): ValidationRules
    {
        return validation_rules([
            'string'
        ]);
    }

    public function getOrganizationOwnershipTypeValidationRules(): ValidationRules
    {
        return validation_rules([
            new ExistsOwnershipTypeRule()
        ]);
    }

    public function getOrganizationNameUniqueValidationRule(): Unique
    {
        return Rule::unique(OrganizationModel::TABLE, Organization::NAME);
    }

    public function getOrganizationPhoneNumberValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getOrganizationPhoneNumberUniqueValidationRule(),
            $this->getOrganizationPhoneNumberValidationRule()
        ]);
    }

    public function getOrganizationPhoneNumberValidationRule(): PhoneNumberValidationRule
    {
        return PhoneNumber::getValidationRule();
    }

    public function getOrganizationPhoneNumberUniqueValidationRule(): Unique
    {
        return Rule::unique(OrganizationModel::TABLE, Organization::PHONE_NUMBER);
    }

    public function getOrganizationEmailValidationRules(): ValidationRules
    {
        return validation_rules([
            'email',
            $this->getOrganizationEmailUniqueValidationRule()
        ]);
    }

    public function getOrganizationEmailUniqueValidationRule(): Unique
    {
        return Rule::unique(OrganizationModel::TABLE, Organization::EMAIL);
    }

    public function getOrganizationIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(OrganizationModel::TABLE, $column);
    }

    public function getOrganizationCountryValidationRules(): ValidationRules
    {
        return validation_rules([
            new ExistsCounterpartyCountryRule()
        ]);
    }

    public function getOrganizationBankDataValidationRules(): ValidationRules
    {
        return $this->getParamsValidationRules();
    }
}
