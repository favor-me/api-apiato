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

namespace App\Containers\AppSection\User\ShiftParams;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\ShiftParams\Elements\FixRateParamElement;
use App\Containers\AppSection\User\ShiftParams\Elements\PercentFromOrderProfitParamElement;
use App\Ship\Params\Schema as ShipSchema;

class Schema extends ShipSchema
{
    public function build(): void
    {
        $this->elements
            ->add(
                (new FixRateParamElement($this->model))->get()
            )
            ->add(
                (new PercentFromOrderProfitParamElement($this->model))->get()
            );
    }

    public static function getElementsValidationRules(): array
    {
        $fixRateKey = User::SHIFT_PARAMS . '.' . User::SHIFT_PARAMS_FIX_RATE;
        $percentOrderProfitKey = User::SHIFT_PARAMS . '.' . User::SHIFT_PARAMS_PERCENT_FROM_ORDER_PROFIT;

        return [
            $fixRateKey => FixRateParamElement::getValidationRules(),
            $percentOrderProfitKey => PercentFromOrderProfitParamElement::getValidationRules()
        ];
    }

    public static function getElementsValidationRuleMessages(): array
    {
        return FixRateParamElement::getValidationRuleMessages() +
            PercentFromOrderProfitParamElement::getValidationRuleMessages();
    }
}
