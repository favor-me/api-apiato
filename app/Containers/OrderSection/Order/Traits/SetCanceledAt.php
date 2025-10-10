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

namespace App\Containers\OrderSection\Order\Traits;

use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Status\Models\Status;

trait SetCanceledAt
{
    protected function setCanceledAt(OrderModel $order): void
    {
        if (!is_null($order->status_id)) {
            if ($order->status->slug === Status::CANCELED) {
                $order->setCanceledAt();
            }
        }
    }
}
