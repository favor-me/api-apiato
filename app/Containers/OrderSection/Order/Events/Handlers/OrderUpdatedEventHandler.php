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

use App\Containers\CommunitySection\OrganizationUnit\Tasks\MinusOrganizationUnitBalanceTask;
use App\Containers\OrderSection\Item\Models\Item;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Events\Event;

class OrderUpdatedEventHandler extends Event
{
    public function handle(OrderModel $order): void
    {
        if (!is_null($order->status_id)) {
            if ($order->status->slug === StatusModel::COMPLETED) {
                $this->orderItemsMinusBalance($order);
            }
        }
    }

    /**
     * @param OrderModel $order
     * @return void
     */
    protected function orderItemsMinusBalance(OrderModel $order): void
    {
        $order->items
            ->each(
                fn (Item $item) => $this->orderItemMinusBalance($item, $order)
            );
    }

    /**
     * @param Item $item
     * @param OrderModel $order
     * @return void
     * @throws UpdateResourceFailedException
     */
    protected function orderItemMinusBalance(Item $item, OrderModel $order): void
    {
        if (!is_null($item->unit_id)) {
            app(MinusOrganizationUnitBalanceTask::class)->run($item->unit, $item->amount, $order);
        }
    }
}
