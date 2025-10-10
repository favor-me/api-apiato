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

namespace App\Containers\OrderSection\Order\Tasks;

use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;

class OrderHasStatusTask extends OrderTask
{
    public function run(mixed $order): bool
    {
        if (!$order instanceof OrderModel) {
            $order = $this->repository->find($order, [
                Order::STATUS_ID
            ]);
        }

        return !is_null($order->status_id);
    }
}
