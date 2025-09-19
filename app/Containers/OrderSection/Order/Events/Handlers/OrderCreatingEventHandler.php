<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\OrderSection\Order\Events\Handlers;

use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Ship\Parents\Events\Event;
use Illuminate\Support\Facades\DB;

class OrderCreatingEventHandler extends Event
{
    public function handle(OrderModel $order): void
    {
        $lastOid = DB::table($order::TABLE)
            ->where(Order::ORGANIZATION_ID, $order->organization_id)
            ->max(Order::OID);

        $order->setAttribute(Order::OID, (int)$lastOid + 1);
    }
}
