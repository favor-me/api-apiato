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

namespace App\Containers\ShiftSection\ItemType;

use App\Containers\ShiftSection\ItemType\Facades\Container;
use App\Ship\Foundation\Manager\AbstractItem;
use App\Ship\SimpleTypes\Type\Money;

abstract class Type extends AbstractItem
{
    public function getTitle(): string
    {
        return (string)Container::trans('container.' . $this->getName() . '.title');
    }

    public function calculateShiftValue(Money &$shiftValue, Money $itemValue): void
    {
        $shiftValue->add($itemValue);
    }
}
