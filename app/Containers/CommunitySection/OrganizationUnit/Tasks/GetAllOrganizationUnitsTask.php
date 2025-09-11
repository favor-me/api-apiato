<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Tasks;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Ship\Criterias\ThisEqualThatCriteria;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUnitsTask extends OrganizationUnitTask
{
    /**
     * @param mixed|null $limit
     * @return LengthAwarePaginator
     * @throws RepositoryException
     */
    public function run(mixed $limit = null): LengthAwarePaginator
    {
        return $this->repository->paginate($limit);
    }

    /**
     * @param mixed $id
     * @return $this
     * @throws RepositoryException
     */
    public function organization(mixed $id): self
    {
        $this->repository
            ->pushCriteria(
                new ThisEqualThatCriteria(OrganizationUnit::ORGANIZATION_ID, (int)$id)
            );

        return $this;
    }
}
