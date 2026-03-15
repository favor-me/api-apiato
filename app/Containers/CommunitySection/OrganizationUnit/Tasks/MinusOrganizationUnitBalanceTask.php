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

namespace App\Containers\CommunitySection\OrganizationUnit\Tasks;

use App\Containers\CommunitySection\OrganizationUnit\Events\MinusOrganizationUnitBalanceEvent;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Exception;

class MinusOrganizationUnitBalanceTask extends OrganizationUnitTask
{
    /**
     * @param OrganizationUnitModel $unit
     * @param float $minusBalance
     * @param OrderModel $order
     * @return OrganizationUnitModel
     * @throws UpdateResourceFailedException
     */
    public function run(OrganizationUnitModel $unit, float $minusBalance, OrderModel $order): OrganizationUnitModel
    {
        try {
            $newBalance = (float)$unit->balance - $minusBalance;

            if ($unit->is_infinity_balance) {
                $newBalance = $unit->balance;
            }

            $data = [
                UnitPrice::BALANCE => $newBalance,
            ];

            $resultUnit = $this->repository->update($data, $unit->id);

            event(
                new MinusOrganizationUnitBalanceEvent(
                    $resultUnit,
                    $minusBalance,
                    $unit->balance,
                    $order
                )
            );

            return $resultUnit;
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
