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

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Data\Criterias\JoinUnitPriceCriteria;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Traits\SetPriceFrom;
use App\Ship\Criterias\ThisEqualThatCriteria;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUnitsTask extends OrganizationUnitTask
{
    use SetPriceFrom;

    /**
     * @param mixed|null $limit
     * @return LengthAwarePaginator
     * @throws RepositoryException
     */
    public function run(mixed $limit = null): LengthAwarePaginator
    {
        if ($this->hasPriceFrom()) {
            $this->repository
                ->pushCriteria(
                    new JoinUnitPriceCriteria($this->priceFrom)
                );
        }

        return $this->repository->paginate($limit);
    }

    /**
     * @param int $id
     * @return $this
     * @throws RepositoryException
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function organization(int $id): self
    {
        $this->repository
            ->pushCriteria(
                new ThisEqualThatCriteria(OrganizationUnitModel::TABLE . '.' . OrganizationUnit::ORGANIZATION_ID, $id)
            );

        return $this;
    }
}
