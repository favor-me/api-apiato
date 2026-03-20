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

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\GetAllIOrganizationUnitsByIdsTask;
use App\Containers\OrderSection\Item\Dto\CreateItemDto;
use App\Containers\OrderSection\Item\Dto\UpdateItemDto;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Tasks\CreateItemTask;
use App\Containers\OrderSection\Item\Tasks\UpdateItemTask;
use App\Containers\OrderSection\Order\Dto\UpdateOrderDto;
use App\Containers\OrderSection\Order\Jobs\UpdateOrderShiftItemJob;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\OrderSection\Order\Tasks\CalculateOrderTotalTask;
use App\Containers\OrderSection\Order\Tasks\UpdateOrderTask;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UpdateOrderAction extends Action
{
    /**
     * @param UpdateOrderDto $dto
     * @return Order
     * @throws CreateResourceFailedException
     * @throws RepositoryException
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateOrderDto $dto): Order
    {
        $order = app(UpdateOrderTask::class)->run($dto);

        $this->createOrUpdateItems($order, $dto);
        if ($dto->hasItems()) {
            $order = app(CalculateOrderTotalTask::class)->run($order);
        }

        dispatch(new UpdateOrderShiftItemJob($order));

        return $order;
    }

    /**
     * @param Order $order
     * @param UpdateOrderDto $dto
     * @return void
     * @throws CreateResourceFailedException
     * @throws RepositoryException
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    protected function createOrUpdateItems(Order $order, UpdateOrderDto $dto): void
    {
        if ($dto->hasItems()) {
            $items = $this->getOrganizationUnits($dto);
            collect($dto->items)
                ->each(function (array $itemData) use ($order, $items) {
                    $itemData += [
                        Item::ORDER_ID => $order->id
                    ];

                    if (array_key_exists(Item::UNIT_ID, $itemData)) {
                        $itemData[Item::UNIT_CLIENT_PRICE] = $items->get($itemData[Item::UNIT_ID]);
                    }

                    if (array_key_exists(ID, $itemData)) {
                        $this->updateItem($itemData);
                    } else {
                        $this->createItem($itemData);
                    }
                });
        }
    }

    /**
     * @param array $itemData
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    protected function createItem(array $itemData): void
    {
        app(CreateItemTask::class)
            ->run(
                new CreateItemDto($itemData)
            );
    }

    /**
     * @param array $itemData
     * @return void
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    protected function updateItem(array $itemData): void
    {
        app(UpdateItemTask::class)
            ->run(
                new UpdateItemDto($itemData)
            );
    }

    /**
     * @param UpdateOrderDto $dto
     * @return Collection
     * @throws RepositoryException
     */
    protected function getOrganizationUnits(UpdateOrderDto $dto): Collection
    {
        return app(GetAllIOrganizationUnitsByIdsTask::class)
            ->setColumns([
                ID,
                UnitPrice::CLIENT_PRICE
            ])
            ->run($dto->itemsIds())
            ->pluck(OrganizationUnit::PRIORITY_CLIENT_PRICE, ID);
    }
}
