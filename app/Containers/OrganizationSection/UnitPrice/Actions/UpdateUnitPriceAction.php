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

use App\Containers\OrganizationSection\UnitPrice\Dto\UpdateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Tasks\UpdateUnitPriceTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateUnitPriceAction extends Action
{
    /**
     * @param UpdateUnitPriceDto $dto
     * @return UnitPrice
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateUnitPriceDto $dto): UnitPrice
    {
        return app(UpdateUnitPriceTask::class)->run($dto);
    }
}
