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

namespace App\Containers\OrderSection\Order\Actions;

use App\Containers\OrderSection\Item\Dto\UpdateItemDto;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Tasks\UpdateItemTask;
use App\Containers\OrderSection\Order\Dto\UpdateOrderDto;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\OrderSection\Order\Tasks\CalculateOrderTotalTask;
use App\Containers\OrderSection\Order\Tasks\UpdateOrderTask;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateOrderAction extends Action
{
    /**
     * @param UpdateOrderDto $dto
     * @return Order
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateOrderDto $dto): Order
    {
        $order = app(UpdateOrderTask::class)->run($dto);

        $this->updateItems($order, $dto);
        if ($dto->hasItems()) {
            return app(CalculateOrderTotalTask::class)->run($order);
        }

        return $order;
    }

    /**
     * @param Order $order
     * @param UpdateOrderDto $dto
     * @return void
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    protected function updateItems(Order $order, UpdateOrderDto $dto): void
    {
        if ($dto->hasItems()) {
            collect($dto->items)
                ->each(function (array $itemData) use ($order) {
                    $itemData[Item::ORDER_ID] = $order->id;
                    $this->updateItem(new UpdateItemDto($itemData));
                });
        }
    }

    /**
     * @param UpdateItemDto $dto
     * @return void
     * @throws UpdateResourceFailedException
     */
    protected function updateItem(UpdateItemDto $dto): void
    {
        app(UpdateItemTask::class)->run($dto);
    }
}
