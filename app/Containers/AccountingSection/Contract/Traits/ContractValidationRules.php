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

namespace App\Containers\AccountingSection\Contract\Traits;

use App\Containers\AccountingSection\Contract\Facades\Container;
use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait ContractValidationRules
{
    public function getContractIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getContractIdExistsValidationRule(ID)
        ]);
    }

    public function getContractNameValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Contract::NAME));
    }

    public function getContractStartAtValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Contract::START_AT));
    }
    public function getContractFinishAtValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Contract::FINISH_AT));
    }

    public function getContractIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(ContractModel::TABLE, $column);
    }
}
