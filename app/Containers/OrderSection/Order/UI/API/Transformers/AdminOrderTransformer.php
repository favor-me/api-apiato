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

namespace App\Containers\OrderSection\Order\UI\API\Transformers;

use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;

class AdminOrderTransformer extends OrderTransformer
{
    public function transform(OrderModel $order): array
    {
        return parent::transform($order) +
            [
                $this->realKey(ID) => $order->id,
                $this->realKey(Order::ORGANIZATION_ID) => $order->organization_id,
                $this->realKey(Order::CLIENT_ID) => $order->client_id,
                $this->realKey('created_by') => $order->created_by,
                $this->realKey('updated_by') => $order->updated_by
            ];
    }
}
