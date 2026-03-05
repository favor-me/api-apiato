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

namespace App\Containers\ShiftSection\Item\Traits;

use App\Containers\ShiftSection\Item\Facades\Container;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
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

    public function getItemTypeValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::TYPE));
    }

    public function getItemValueValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::VALUE));
    }

    public function getItemDescriptionValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Item::DESCRIPTION));
    }

    public function getItemIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(ItemModel::TABLE, $column);
    }
}
