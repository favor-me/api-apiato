<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Criterias\SpecialistsForTomorrowNotificationCriteria;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllSpecialistsForTomorrowNotificationTask extends UserTask
{
    /**
     * @param int $limit
     * @param int $offset
     * @return Collection
     * @throws RepositoryException
     */
    public function run(int $limit, int $offset = ZERO): Collection
    {
        return $this->repository
            ->pushCriteria(new SpecialistsForTomorrowNotificationCriteria())
            ->scopeQuery(function (Builder $builder) use ($limit, $offset) {
                return $builder
                    ->limit($limit)
                    ->offset($offset);
            })
            ->get([User::TABLE . '.*']);
    }
}
