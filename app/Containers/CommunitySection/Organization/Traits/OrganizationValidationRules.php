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

use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Ship\Validation\Rules\PhoneNumber as PhoneNumberValidationRule;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Support\PhoneNumber;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\Rules\Exists;

trait OrganizationValidationRules
{
    public function getOrganizationIdValidationRules(): ValidationRulesCollection
    {
        return validation_rules([
            $this->getOrganizationIdExistsValidationRule(ID)
        ]);
    }

    public function getOrganizationNameValidationRules(): ValidationRulesCollection
    {
        return validation_rules([
            $this->getOrganizationNameUniqueValidationRule()
        ]);
    }

    public function getOrganizationNameUniqueValidationRule(): Unique
    {
        return Rule::unique(OrganizationModel::TABLE, Organization::NAME);
    }

    public function getOrganizationInnValidationRules(): ValidationRulesCollection
    {
        return validation_rules([
            $this->getOrganizationInnUniqueValidationRule()
        ]);
    }

    public function getOrganizationInnUniqueValidationRule(): Unique
    {
        return Rule::unique(OrganizationModel::TABLE, Organization::INN);
    }

    public function getOrganizationPhoneNumberValidationRules(): ValidationRulesCollection
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

    public function getOrganizationEmailValidationRules(): ValidationRulesCollection
    {
        return validation_rules([
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
}
