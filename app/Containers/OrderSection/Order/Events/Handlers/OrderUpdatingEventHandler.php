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

use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Traits\SetCanceledAt;
use App\Containers\OrderSection\Order\Traits\SetCompletedAt;
use App\Ship\Parents\Events\Event;

class OrderUpdatingEventHandler extends Event
{
    use SetCompletedAt;
    use SetCanceledAt;

    public function handle(OrderModel $order): void
    {
        $this->setCompletedAt($order);
        $this->setCanceledAt($order);
    }
}
