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
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Tasks\CreateItemTask;
use App\Containers\OrderSection\Order\Dto\CreateOrderDto;
use App\Containers\OrderSection\Order\Jobs\CreateOrderShiftItemJob;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\OrderSection\Order\Tasks\CalculateOrderTotalTask;
use App\Containers\OrderSection\Order\Tasks\CreateOrderTask;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CreateOrderAction extends Action
{
    /**
     * @param CreateOrderDto $dto
     * @return Order
     * @throws CreateResourceFailedException
     * @throws RepositoryException
     * @throws UnknownProperties
     */
    public function run(CreateOrderDto $dto): Order
    {
        $order = app(CreateOrderTask::class)->run($dto);

        $this->createItems($order, $dto);
        if ($dto->hasItems()) {
            $order = app(CalculateOrderTotalTask::class)->run($order);
        }

        dispatch(new CreateOrderShiftItemJob($order));

        return $order;
    }

    /**
     * @param Order $order
     * @param CreateOrderDto $dto
     * @return void
     * @throws CreateResourceFailedException
     * @throws RepositoryException
     * @throws UnknownProperties
     */
    protected function createItems(Order $order, CreateOrderDto $dto): void
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

    /**
     * @param CreateOrderDto $dto
     * @return Collection
     * @throws RepositoryException
     */
    protected function getOrganizationUnits(CreateOrderDto $dto): Collection
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
