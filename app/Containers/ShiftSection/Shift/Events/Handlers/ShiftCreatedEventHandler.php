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

namespace App\Containers\ShiftSection\Shift\Events\Handlers;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\ShiftSection\Item\Dto\CreateItemDto;
use App\Containers\ShiftSection\Item\Dto\SystemNoteDto;
use App\Containers\ShiftSection\Item\Facades\Container as ItemContainer;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Tasks\CreateItemTask;
use App\Containers\ShiftSection\ItemType\IncomeType;
use App\Containers\ShiftSection\ItemType\Manager;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Events\Event;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ShiftCreatedEventHandler extends Event
{
    /**
     * @param ShiftModel $shift
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function handle(ShiftModel $shift): void
    {
        $this->createShiftItemFixRate($shift);
    }

    /**
     * @param ShiftModel $shift
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    protected function createShiftItemFixRate(ShiftModel $shift): void
    {
        $paramKey = User::SHIFT_PARAMS_FIX_RATE;
        $shiftFixRate = (int)$shift->creator->shift_params->get($paramKey);

        if ($shiftFixRate > ZERO) {
            $type = Manager::getInstance()
                ->get(IncomeType::class)
                ->getName();

            $fixRateMoney = app('money')->addCurrency($shiftFixRate);

            $systemNote = new SystemNoteDto(
                ItemContainer::transFullKey('container.system_note.' . $paramKey)
            );

            $dto = new CreateItemDto([
                Item::SHIFT_ID => $shift->id,
                Item::TYPE => $type,
                Item::VALUE => $fixRateMoney->val(),
                Item::SYSTEM_NOTE => $systemNote->toArray()
            ]);

            app(CreateItemTask::class)->run($dto);
        }
    }
}
