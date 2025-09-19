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

namespace App\Containers\OrderSection\Order\Traits;

use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait OrderValidationRules
{
    public function getOrderIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getOrderIdExistsValidationRule(ID)
        ]);
    }

    public function getOrderPaymentTypeValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Order::PAYMENT_TYPE));
    }

    public function getOrderTotalValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Order::TOTAL));
    }

    public function getOrderCommentValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Order::COMMENT));
    }

    public function getOrderIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(OrderModel::TABLE, $column)
            ->where(Order::ORGANIZATION_ID, $this->organization_id);
    }
}
