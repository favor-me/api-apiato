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

namespace App\Containers\OrderSection\Order\Events\Handlers;

use App\Containers\OrderSection\Order\Events\TrashedOrdersEvent;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\ShiftSection\Item\Models\Item as ShiftItemModel;
use App\Containers\ShiftSection\Item\Tasks\DeleteItemsTask;
use App\Ship\Parents\Events\Event;
use Prettus\Repository\Exceptions\RepositoryException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TrashedOrderEventHandler extends Event
{
    /**
     * @param TrashedOrdersEvent $event
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RepositoryException
     */
    public function handle(TrashedOrdersEvent $event): void
    {
        $event
            ->getOrders()
            ->each(function (Order $order) {
                if ($order->shift_id) {
                    /** @var null|ShiftItemModel $orderShiftItem */
                    $orderShiftItem = $order->shift->items
                        ->first(
                            fn(ShiftItemModel $item) => $item->order_id === $order->id
                        );

                    if (!is_null($orderShiftItem)) {
                        app(DeleteItemsTask::class)->run([
                            $orderShiftItem->id
                        ]);
                    }

                    $order->shift
                        ->calculate()
                        ->save();
                }
            });
    }
}
