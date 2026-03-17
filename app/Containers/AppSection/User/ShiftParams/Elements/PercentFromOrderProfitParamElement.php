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

namespace App\Containers\AppSection\User\ShiftParams\Elements;

use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Foundation\User;
use App\Ship\Collections\ValidationRules;
use App\Ship\Params\FloatParam;

class PercentFromOrderProfitParamElement extends FloatParam
{
    public const int MAX = 100;

    protected string $name = User::SHIFT_PARAMS_PERCENT_FROM_ORDER_PROFIT;

    public static function getValidationRules(): ValidationRules
    {
        return parent::getValidationRules()
            ->add('max:' . self::MAX)
            ->add('numeric');
    }

    public static function getValidationRuleMessages(): array
    {
        $key = User::SHIFT_PARAMS . '.' . User::SHIFT_PARAMS_PERCENT_FROM_ORDER_PROFIT;
        $paramKey = 'container.shift_params.percent_from_order_profit.validation';

        return [
            $key . '.numeric' => Container::trans($paramKey . '.number'),
            $key . '.max' => Container::trans($paramKey . '.max', ['max' => self::MAX]),
        ];
    }

    protected function getTitle(): string
    {
        return Container::trans('container.shift_params.' . $this->name . '.title');
    }

    protected function getHint(): string
    {
        return Container::trans('container.shift_params.' . $this->name . '.hint');
    }

    protected function modelColumnName(): string
    {
        return User::SHIFT_PARAMS;
    }
}
