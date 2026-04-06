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

namespace App\Containers\OrderSection\Order\Jobs;

use App\Containers\ShiftSection\Item\Dto\UpdateItemDto;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Item\Tasks\UpdateItemTask;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateOrderShiftItemJob extends OrderShiftItemJob
{
    /**
     * @return null|ItemModel
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    protected function run(): ?ItemModel
    {
        if ($this->order->shift_id) {
            /** @var ItemModel $item */
            $item = $this->order->shift->items
                ->first(
                    fn(ItemModel $item) => $item->order_id === $this->order->id
                );

            // Create shift item on complete order.
            if (is_null($item) && !is_null($this->order->completed_at)) {
                $item = (new CreateOrderShiftItemJob($this->order))->__invoke();
            }

            if (!is_null($item)) {
                $shiftItemOrderIncomeMoney = $this->order->profit
                    ->getClone()
                    ->percentValue($this->orderProfitPercent);

                $dto = new UpdateItemDto([
                    ID => $item->id,
                    Item::VALUE => $shiftItemOrderIncomeMoney->val()
                ]);

                app(UpdateItemTask::class)->run($dto);
            }

            $this->order->shift->calculate()->update();
        }

        return null;
    }
}
