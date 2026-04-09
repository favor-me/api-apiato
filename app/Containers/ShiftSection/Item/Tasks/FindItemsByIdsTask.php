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

namespace App\Containers\ShiftSection\Item\Tasks;

use App\Ship\Criterias\InCriteria;
use App\Ship\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class FindItemsByIdsTask extends ItemTask
{
    /**
     * @param array $ids
     * @return Collection
     * @throws RepositoryException
     */
    public function run(array $ids): Collection
    {
        return $this->repository
            ->pushCriteria(new InCriteria($ids))
            ->all();
    }
}
