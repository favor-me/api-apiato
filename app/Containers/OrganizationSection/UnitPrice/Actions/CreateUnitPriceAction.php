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

namespace App\Containers\OrganizationSection\UnitPrice\Actions;

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrganizationSection\UnitPrice\Dto\CreateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Tasks\CreateUnitPriceTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action;

class CreateUnitPriceAction extends Action
{
    /**
     * @param CreateUnitPriceDto $dto
     * @return OrganizationUnitModel
     * @throws CreateResourceFailedException
     */
    public function run(CreateUnitPriceDto $dto): OrganizationUnitModel
    {
        $unitPrice = app(CreateUnitPriceTask::class)->run($dto);

        return $unitPrice
            ->model()
            ->first()
            ->unitPrices()
            ->where(OrganizationUnitModel::TABLE . '.' . ID, $dto->unit_id)
            ->first();
    }
}
