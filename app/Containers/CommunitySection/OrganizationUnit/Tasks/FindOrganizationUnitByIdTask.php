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

namespace App\Containers\CommunitySection\OrganizationUnit\Tasks;

use App\Containers\AccountingSection\Contract\Models\Contract;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\OrganizationSection\UnitPrice\Traits\UnitPriceList;
use App\Ship\Exceptions\NotFoundException;
use Exception;

class FindOrganizationUnitByIdTask extends OrganizationUnitTask
{
    use UnitPriceList;

    /**
     * @param int $id
     * @return OrganizationUnit
     * @throws NotFoundException
     */
    public function run(int $id): OrganizationUnit
    {
        try {
            return $this->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }

    protected function find(int $id): OrganizationUnit
    {
        $unit = $this->repository->find($id);

        if ($this->isContractPriceList()) {
            $unit
                ->setAttribute(
                    'contractPriceList',
                    $unit
                        ->contractPriceList(
                            $this->priceListModelId
                        )
                        ->get()
                );
        }

        return $unit;
    }

    protected function isContractPriceList(): bool
    {
        return $this->getPriceListModelType()->getModelAccessor() === Contract::class;
    }
}
