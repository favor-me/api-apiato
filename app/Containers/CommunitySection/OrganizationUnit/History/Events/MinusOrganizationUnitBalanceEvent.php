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

namespace App\Containers\CommunitySection\OrganizationUnit\History\Events;

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\HistorySection\ModelNote\Types\SystemMessageModelNoteType;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;

/**
 * @method null|OrganizationUnitModel getModelData()
 */
class MinusOrganizationUnitBalanceEvent extends OrganizationUnitEvent
{
    public const string OLD_BALANCE_VALUE = 'oldBalanceValue';
    public const string MINUS_BALANCE_VALUE = 'minusBalanceValue';
    public const string ORDER = 'order';

    public function getDataChanges(): array
    {
        return [
            UnitPrice::BALANCE => $this->getModelData()->balance
        ];
    }

    public function getData(): array
    {
        return [
            UnitPrice::BALANCE => $this->data->get(self::OLD_BALANCE_VALUE)
        ];
    }

    public function getModelNoteTypeParams(): array
    {
        $message = $this->getModelData()->is_infinity_balance
            ? $this->getModelNoteInfinityMessage() : $this->getModelNoteMessage();

        return [
            SystemMessageModelNoteType::PARAM_KEY_MESSAGE => $message,
            SystemMessageModelNoteType::PARAM_KEY_MESSAGE_ARGS => $this->getModelNoteMessageArgs()
        ];
    }

    protected function getModelNoteInfinityMessage(): string
    {
        return Container::transFullKey('history.' . self::getType() . '.infinity_note_message');
    }

    protected function getModelNoteMessage(): string
    {
        return Container::transFullKey('history.' . self::getType() . '.note_message');
    }

    protected function getModelNoteMessageArgs(): array
    {
        /** @var Order $order */
        $order = $this->data->get(self::ORDER);

        return [
            'old_value' => $this->data->get(self::OLD_BALANCE_VALUE),
            'new_value' => $this->getModelData()->balance,
            'minus_balance' => $this->data->get(self::MINUS_BALANCE_VALUE),
            'order_number' => $order->id,
            'order_id' => $order->getHashedKey(),
        ];
    }
}
