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

class PlusOrganizationUnitBalanceEvent
{
    public function __construct(
        protected OrganizationUnitModel $unit,
        protected float $addBalanceValue,
        protected float $oldBalanceValue
    ) {
    }

    public function getOldBalanceValue(): float
    {
        return $this->oldBalanceValue;
    }

    public function getAddBalanceValue(): float
    {
        return $this->addBalanceValue;
    }

    public function getUnit(): OrganizationUnitModel
    {
        return $this->unit;
    }
}
