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

namespace App\Containers\CommunitySection\OrganizationUnit\Actions;

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\FindOrganizationUnitByIdTask;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\PlusOrganizationUnitBalanceTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action;

class PlusOrganizationUnitBalanceAction extends Action
{
    /**
     * @param int $id
     * @param float $balance
     * @param bool $isInfinity
     * @return OrganizationUnitModel
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run(int $id, float $balance, bool $isInfinity = false): OrganizationUnitModel
    {
        $unit = app(FindOrganizationUnitByIdTask::class)->run($id);
        return app(PlusOrganizationUnitBalanceTask::class)->run($unit, $balance, $isInfinity);
    }
}
