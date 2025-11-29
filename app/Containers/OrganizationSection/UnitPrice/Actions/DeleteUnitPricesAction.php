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

use App\Containers\OrganizationSection\UnitPrice\Map\Type;
use App\Containers\OrganizationSection\UnitPrice\Tasks\DeleteUnitPricesTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

class DeleteUnitPricesAction extends Action
{
    /**
     * @param Type $modelType
     * @param int $modelId
     * @param array $unitIds
     * @return int|null
     * @throws NotFoundException
     */
    public function run(Type $modelType, int $modelId, array $unitIds): ?int
    {
        return app(DeleteUnitPricesTask::class)->run($modelType, $modelId, $unitIds);
    }
}
