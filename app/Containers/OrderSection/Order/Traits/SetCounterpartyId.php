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

use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\PaymentType\ContractType;

trait SetCounterpartyId
{
    protected function setCounterpartyId(OrderModel $order): void
    {
        if ($order->paymentTypeIs(ContractType::class) && $order->contract_id) {
            $order
                ->setAttribute(Order::CLIENT_ID, null)
                ->setAttribute(Order::COUNTERPARTY_ID, $order->contract->counterparty_id);
        }
    }
}
