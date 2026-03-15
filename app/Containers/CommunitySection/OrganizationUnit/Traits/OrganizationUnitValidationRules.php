<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Traits;

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

trait OrganizationUnitValidationRules
{
    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getOrganizationUnitIdExistsValidationRule(ID)
        ]);
    }

    public function getOrganizationUnitNameValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationUnit::NAME))
            ->add($this->getOrganizationUnitNameUniqueValidationRule());
    }

    public function getOrganizationUnitNameUniqueValidationRule(): Unique
    {
        return Rule::unique(OrganizationUnitModel::TABLE, OrganizationUnit::NAME)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->organization_id);
    }

    public function getOrganizationUnitTypeValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationUnit::TYPE));
    }

    public function getOrganizationUnitSkuValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationUnit::SKU))
            ->add($this->getOrganizationUnitSkuUniqueValidationRule());
    }

    public function getOrganizationUnitSkuUniqueValidationRule(): Unique
    {
        return Rule::unique(OrganizationUnitModel::TABLE, OrganizationUnit::SKU)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->organization_id);
    }

    public function getOrganizationUnitOrderingValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . OrganizationUnit::ORDERING));
    }

    public function getOrganizationUnitCostPriceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::COST_PRICE));
    }

    public function getOrganizationUnitClientPriceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::CLIENT_PRICE));
    }

    public function getOrganizationUnitBalanceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::BALANCE));
    }

    public function getOrganizationUnitIsInfinityBalanceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::IS_INFINITY_BALANCE));
    }

    public function getOrganizationUnitIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(OrganizationUnitModel::TABLE, $column);
    }

    public function getOrganizationUnitSkuExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(OrganizationUnitModel::TABLE, $column);
    }
}
