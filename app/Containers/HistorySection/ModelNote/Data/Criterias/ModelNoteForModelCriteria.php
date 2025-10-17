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

namespace App\Containers\HistorySection\ModelNote\Data\Criterias;

use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

final class ModelNoteForModelCriteria extends Criteria
{
    public function __construct(
        protected string $model
    ) {
    }

    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(ModelNote::TABLE . '.' . BaseModelNote::MODEL, $this->model);
    }
}
