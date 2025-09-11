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

namespace App\Containers\CommunitySection\OrganizationUnitType\Actions;

use App\Containers\CommunitySection\OrganizationUnitType\Tasks\GetAllOrganizationUnitTypesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetAllOrganizationUnitTypesAction extends Action
{
    public function run(): Collection
    {
        return app(GetAllOrganizationUnitTypesTask::class)->run();
    }
}
