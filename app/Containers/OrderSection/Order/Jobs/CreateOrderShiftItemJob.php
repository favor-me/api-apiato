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

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\ShiftSection\Item\Dto\CreateItemDto;
use App\Containers\ShiftSection\Item\Dto\SystemNoteDto;
use App\Containers\ShiftSection\Item\Facades\Container as ItemContainer;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Item\Tasks\CreateItemTask;
use App\Containers\ShiftSection\ItemType\IncomeType;
use App\Containers\ShiftSection\ItemType\Manager;
use App\Ship\Exceptions\CreateResourceFailedException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrderShiftItemJob extends OrderShiftItemJob
{
    /**
     * @return null|ItemModel
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    protected function run(): ?ItemModel
    {
        $type = Manager::getInstance()
            ->get(IncomeType::class)
            ->getName();

        $shiftItemOrderIncomeMoney = $this->order->profit
            ->getClone()
            ->percentValue($this->orderProfitPercent);

        $systemNote = new SystemNoteDto(
            ItemContainer::transFullKey('container.system_note.' . User::SHIFT_PARAMS_PERCENT_FROM_ORDER_PROFIT),
            [
                'order_oid' => $this->order->oid
            ]
        );

        $dto = new CreateItemDto([
            Item::TYPE => $type,
            Item::ORDER_ID => $this->order->id,
            Item::SHIFT_ID => $this->order->shift->id,
            Item::SYSTEM_NOTE => $systemNote->toArray(),
            Item::VALUE => $shiftItemOrderIncomeMoney->val()
        ]);

        return app(CreateItemTask::class)->run($dto);
    }
}
