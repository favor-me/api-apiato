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
use App\Containers\OrganizationSection\UnitPrice\Dto\UpdateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Tasks\UpdateUnitPriceTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action;

class UpdateUnitPriceAction extends Action
{
    /**
     * @param UpdateUnitPriceDto $dto
     * @return OrganizationUnitModel
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateUnitPriceDto $dto): OrganizationUnitModel
    {
        $unitPrice = app(UpdateUnitPriceTask::class)->run($dto);

        $unitPrices = $unitPrice
            ->model()
            ->first()
            ->unitPrices();

        if (is_null($unitPrices)) {
            throw new NotFoundException();
        }

        return $unitPrices
            ->where(OrganizationUnitModel::TABLE . '.' . ID, $dto->unit_id)
            ->first();
    }
}
