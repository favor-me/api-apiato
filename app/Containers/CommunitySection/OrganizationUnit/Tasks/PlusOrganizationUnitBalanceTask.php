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

use App\Containers\CommunitySection\OrganizationUnit\Events\PlusOrganizationUnitBalanceEvent;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Exception;

class PlusOrganizationUnitBalanceTask extends OrganizationUnitTask
{
    /**
     * @param OrganizationUnitModel $unit
     * @param float $balance
     * @param bool $isInfinity
     * @return OrganizationUnitModel
     * @throws UpdateResourceFailedException
     */
    public function run(OrganizationUnitModel $unit, float $balance, bool $isInfinity = false): OrganizationUnitModel
    {
        try {
            $newBalance = (float)$unit->balance + $balance;

            if ($isInfinity) {
                $newBalance = ZERO;
            }

            $data = [
                OrganizationUnit::BALANCE => $newBalance,
                OrganizationUnit::IS_INFINITY_BALANCE => $isInfinity
            ];

            $resultUnit = $this->repository->update($data, $unit->id);

            event(new PlusOrganizationUnitBalanceEvent($resultUnit, $balance, $unit->balance));

            return $resultUnit;
        } catch (Exception $e) {
            throw new UpdateResourceFailedException();
        }
    }
}
