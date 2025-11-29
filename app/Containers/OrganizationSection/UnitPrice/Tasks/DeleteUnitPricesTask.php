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

namespace App\Containers\OrganizationSection\UnitPrice\Tasks;

use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\Type;
use App\Ship\Exceptions\NotFoundException;
use Exception;

class DeleteUnitPricesTask extends UnitPriceTask
{
    /**
     * @param Type $modelType
     * @param int $modelId
     * @param array $unitIds
     * @return int
     * @throws NotFoundException
     */
    public function run(Type $modelType, int $modelId, array $unitIds): int
    {
        try {
            return $this->repository
                ->deleteWhere([
                    [UnitPrice::UNIT_ID, 'in', $unitIds],
                    [UnitPrice::MODEL_ID, '=', $modelId],
                    [UnitPrice::MODEL, '=', $modelType->getModelAccessor()]
                ]);
        } catch (Exception $e) {
            throw new NotFoundException($e->getMessage());
        }
    }
}
