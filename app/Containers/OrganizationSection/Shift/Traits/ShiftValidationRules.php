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

namespace App\Containers\OrganizationSection\Shift\Traits;

use App\Containers\OrganizationSection\Shift\Facades\Container;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait ShiftValidationRules
{
    public function getShiftIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getShiftIdExistsValidationRule(ID)
        ]);
    }

    public function getShiftStartAtValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Shift::START_AT));
    }

    public function getShiftFinishAtValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Shift::FINISH_AT));
    }
    public function getShiftCreatedByValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . 'created_by'));
    }

    public function getShiftIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(ShiftModel::TABLE, $column);
    }
}
