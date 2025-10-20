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

namespace App\Containers\CommunitySection\OrganizationUnit\Events;

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrderSection\Order\Models\Order;

class MinusOrganizationUnitBalanceEvent
{
    public function __construct(
        protected OrganizationUnitModel $unit,
        protected float $minusBalanceValue,
        protected ?float $oldBalanceValue,
        protected Order $order
    ) {
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getOldBalanceValue(): float
    {
        return (float)$this->oldBalanceValue;
    }

    public function getMinusBalanceValue(): float
    {
        return $this->minusBalanceValue;
    }

    public function getUnit(): OrganizationUnitModel
    {
        return $this->unit;
    }
}
