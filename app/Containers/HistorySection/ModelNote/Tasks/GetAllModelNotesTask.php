<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelNote\Tasks;

use App\Containers\HistorySection\ModelNote\Data\Criterias\ModelNoteForModelCriteria;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllModelNotesTask extends ModelNoteTask
{
    /**
     * @param int|string|null $limit
     * @return LengthAwarePaginator
     * @throws RepositoryException
     */
    public function run(null|int|string $limit = null): LengthAwarePaginator
    {
        return $this->repository->paginate($limit);
    }

    /**
     * @param Criteria|null $criteria
     * @return $this
     * @throws RepositoryException
     */
    public function addCriteria(?Criteria $criteria): self
    {
        if (!is_null($criteria)) {
            $this->repository->pushCriteria($criteria);
        }

        return $this;
    }

    /**
     * @param string $model
     * @return $this
     * @throws RepositoryException
     */
    public function forModel(string $model): self
    {
        $this->repository->pushCriteria(new ModelNoteForModelCriteria($model));
        return $this;
    }
}
