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

namespace App\Containers\CommunitySection\OrganizationBranch\Traits;

use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait OrganizationBranchValidationRules
{
    public function getOrganizationBranchIdValidationRules(): ValidationRulesCollection
    {
        return validation_rules([
            $this->getOrganizationBranchIdExistsValidationRule(ID)
        ]);
    }

    public function getOrganizationBranchNameValidationRules(): ValidationRulesCollection
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationBranch::NAME));
    }

    public function getOrganizationBranchPhoneNumberValidationRules(): ValidationRulesCollection
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationBranch::PHONE_NUMBER));
    }

    public function getOrganizationBranchLocationValidationRules(): ValidationRulesCollection
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationBranch::LOCATION));
    }

    public function getOrganizationBranchLatitudeValidationRules(): ValidationRulesCollection
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationBranch::LATITUDE));
    }

    public function getOrganizationBranchLongitudeValidationRules(): ValidationRulesCollection
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationBranch::LONGITUDE));
    }

    public function getOrganizationBranchIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(OrganizationBranchModel::TABLE, $column);
    }
}
