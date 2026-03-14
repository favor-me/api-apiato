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

namespace App\Containers\OrganizationSection\UnitPrice\Traits;

use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait UnitPriceValidationRules
{
    public function getUnitPriceIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getUnitPriceIdExistsValidationRule(ID)
        ]);
    }

    public function getUnitPriceModelValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::MODEL));
    }

    public function getUnitPriceModelIdValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::MODEL_ID));
    }

    public function getUnitPriceCostPriceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::COST_PRICE));
    }

    public function getUnitPriceClientPriceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::CLIENT_PRICE));
    }

    public function getUnitPriceBalanceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::BALANCE));
    }

    public function getUnitPriceIsInfinityValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . UnitPrice::IS_INFINITY_BALANCE));
    }

    public function getUnitPriceIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(UnitPriceModel::TABLE, $column);
    }
}
