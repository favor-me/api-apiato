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

use App\Containers\CommunitySection\OrganizationUnit\Data\Criterias\JoinUnitPriceCriteria;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Traits\SetPriceFrom;
use App\Ship\Exceptions\NotFoundException;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class FindOrganizationUnitByIdTask extends OrganizationUnitTask
{
    use SetPriceFrom;

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

    /**
     * @param int $id
     * @return OrganizationUnit
     * @throws RepositoryException
     */
    protected function find(int $id): OrganizationUnit
    {
        if ($this->hasPriceFrom()) {
            $this->repository
                ->pushCriteria(
                    new JoinUnitPriceCriteria($this->priceFrom)
                );
        }

        return $this->repository->find($id);
    }
}
