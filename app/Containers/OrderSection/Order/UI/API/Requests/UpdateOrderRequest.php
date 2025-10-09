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

namespace App\Containers\OrderSection\Order\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrderSection\Item\Collections\ItemEloquentCollection;
use App\Containers\OrderSection\Item\Models\Item;
use App\Containers\OrderSection\Order\Data\Repositories\OrderRepository;
use App\Containers\OrderSection\Order\Dto\UpdateOrderDto;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @method UpdateOrderDto getDto()
 */
class UpdateOrderRequest extends CreateOrderRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_WORKER,
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected array $urlParameters = [
        ID
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();

        $this->mergeDecode([
            ID,
            Order::ITEMS . '.*.' . ID
        ]);
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ID => $this->getOrderIdValidationRules(),
            Order::ITEMS . '.*.' . ID => $this->getItemIdValidationRules(),
        ]);
    }

    public function getOrderTotalValidationRules(): ValidationRules
    {
        $rules = parent::getOrderTotalValidationRules();
        $items = (array)$this->get(Order::ITEMS);

        if (count($items) === ZERO) {
            $rules = $rules->removeRequired();
        }

        return $rules;
    }

    public function getOrderItemsValidationRules(): ValidationRules
    {
        return parent::getOrderItemsValidationRules()
            ->removeRequired();
    }

    public function getOrderIdValidationRules(): ValidationRules
    {
        return parent::getOrderIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationClientIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationClientIdValidationRules()
            ->removeRequired();
    }

    public function getOrderPaymentTypeValidationRules(): ValidationRules
    {
        return parent::getOrderPaymentTypeValidationRules()
            ->removeRequired();
    }

    public function newDto(array $data = []): UpdateOrderDto
    {
        return new UpdateOrderDto($data);
    }

    protected function prepareItemsPrices(): void
    {
        parent::prepareItemsPrices();

        $items = collect((array)$this->items);

        if ($items->isNotEmpty()) {
            $requestItemIds = $items
                ->pluck(ID)
                ->where(function (mixed $id) {
                    return !is_null($id);
                })
                ->toArray();

            /** @var OrderModel $order */
            $order = app(OrderRepository::class)->find($this->id);

            if (!is_null($order)) {
                /** @var ItemEloquentCollection $skippedOrderItems */
                $skippedOrderItems = $order
                    ->items()
                    ->whereNotIn(ID, $requestItemIds)
                    ->get();

                $this->prepareSkippedItemsPrices($skippedOrderItems);
            }
        }
    }

    protected function prepareSkippedItemsPrices(ItemEloquentCollection $items): void
    {
        if ($items->isNotEmpty()) {
            $items->each(
                function (Item $item) {
                    $this->total->add($item->getTotalClientPrice());
                }
            );
        }
    }

    /**
     * @return bool
     * @throws ValidationFailedException
     * @throws AuthorizationException
     */
    protected function passesAuthorization(): bool
    {
        $result = parent::passesAuthorization();
        if ($result === true) {
            $this->throwIfEmptyInput();
        }

        return $result;
    }
}
