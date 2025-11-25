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

namespace App\Containers\CommunitySection\OrganizationUnit\Actions;

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\FindOrganizationUnitByIdTask;
use App\Containers\OrganizationSection\UnitPrice\Traits\UnitPriceList;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

class FindOrganizationUnitByIdAction extends Action
{
    use UnitPriceList;

    /**
     * @param int $id
     * @return OrganizationUnit
     * @throws NotFoundException
     */
    public function run(int $id): OrganizationUnit
    {
        $task = app(FindOrganizationUnitByIdTask::class);

        if (!is_null($this->priceListModel)) {
            $task->priceList(
                $this->priceListModel,
                $this->priceListModelId
            );
        }

        return $task->run($id);
    }
}
