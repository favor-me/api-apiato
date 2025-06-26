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

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class ThisCreatedByCriteria extends Criteria
{
    public function __construct(
        private ?int $createdBy,
        private ?string $table = null
    ) {
    }

    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        if (!$this->createdBy && !is_null(Auth::user())) {
            $this->createdBy = Auth::user()->id;
        }

        $column = CREATED_BY;

        if (!is_null($this->table)) {
            $column = $this->table . '.' . CREATED_BY;
        }

        return $model->where($column, $this->createdBy);
    }
}
