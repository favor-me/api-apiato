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

use App\Containers\OrderSection\Item\Dto\CreateItemDto;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Tasks\CreateItemTask;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\OrderSection\Order\Dto\CreateOrderDto;
use App\Containers\OrderSection\Order\Tasks\CalculateOrderTotalTask;
use App\Containers\OrderSection\Order\Tasks\CreateOrderTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrderAction extends Action
{
    /**
     * @param CreateOrderDto $dto
     * @return Order
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function run(CreateOrderDto $dto): Order
    {
        $order = app(CreateOrderTask::class)->run($dto);

        $this->createItems($order, $dto);
        if ($dto->hasItems()) {
            return app(CalculateOrderTotalTask::class)->run($order);
        }

        return $order;
    }

    /**
     * @param Order $order
     * @param CreateOrderDto $dto
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    protected function createItems(Order $order, CreateOrderDto $dto): void
    {
        if ($dto->hasItems()) {
            collect($dto->items)
                ->each(function (array $itemData) use ($order) {
                    $itemData[Item::ORDER_ID] = $order->id;
                    $this->createItem(new CreateItemDto($itemData));
                });
        }
    }

    /**
     * @param CreateItemDto $dto
     * @return void
     * @throws CreateResourceFailedException
     */
    protected function createItem(CreateItemDto $dto): void
    {
        app(CreateItemTask::class)->run($dto);
    }
}
