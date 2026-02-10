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

use App\Ship\Criterias\InCriteria;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Traits\SetColumns;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllIOrganizationUnitsByIdsTask extends OrganizationUnitTask
{
    use SetColumns;

    /**
     * @param array $ids
     * @return Collection
     * @throws RepositoryException
     */
    public function run(array $ids): Collection
    {
        return $this->repository
            ->pushCriteria(
                new InCriteria($ids, ID)
            )
            ->all($this->getColumns());
    }
}
