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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class OnlyTrashedCriteria extends Criteria
{
    /**
     * @param Builder|Model $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
            return $model->onlyTrashed();
        }

        return $model;
    }
}
