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

namespace App\Containers\OrderSection\Item\Traits;

use App\Containers\OrderSection\Item\Facades\Container;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait ItemValidationRules
{
    public function getItemIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getItemIdExistsValidationRule(ID)
        ]);
    }

    public function getItemNameValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::NAME));
    }

    public function getItemTypeValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::TYPE));
    }

    public function getItemSkuValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::SKU));
    }

    public function getItemCostPriceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::COST_PRICE));
    }

    public function getItemClientPriceValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::CLIENT_PRICE));
    }

    public function getItemAmountValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::AMOUNT));
    }

    public function getItemIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(ItemModel::TABLE, $column);
    }
}
