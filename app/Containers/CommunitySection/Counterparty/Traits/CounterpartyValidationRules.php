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

namespace App\Containers\CommunitySection\Counterparty\Traits;

use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Validation\HasParamsValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait CounterpartyValidationRules
{
    use HasParamsValidationRules;

    public function getCounterpartyIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getCounterpartyIdExistsValidationRule(ID)
        ]);
    }

    public function getCounterpartyNameValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Counterparty::NAME));
    }

    public function getCounterpartyLegalAddressValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Counterparty::LEGAL_ADDRESS));
    }

    public function getCounterpartyMailingAddressValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Counterparty::LEGAL_ADDRESS));
    }

    public function getCounterpartyPhoneNumberValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Counterparty::PHONE_NUMBER));
    }

    public function getCounterpartyEmailValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Counterparty::EMAIL));
    }

    public function getCounterpartyCountryValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Counterparty::COUNTRY));
    }

    public function getCounterpartyOwnershipTypeValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Counterparty::OWNERSHIP_TYPE));
    }

    public function getCounterpartyBankDataValidationRules(): ValidationRules
    {
        return $this->getParamsValidationRules();
    }

    public function getCounterpartyIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(CounterpartyModel::TABLE, $column);
    }
}
