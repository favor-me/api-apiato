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

use Illuminate\Support\Str;
use Illuminate\Database\Query\Builder;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class OrderByFieldCriteria
 *
 * @package App\Ship\Criterias
 */
class OrderByFieldCriteria extends Criteria
{
    /**
     * Hold field.
     *
     * @var string
     */
    private string $field;

    /**
     * Hold sort order.
     *
     * @var string
     */
    private string $sortOrder;

    /**
     * OrderByFieldCriteria constructor.
     *
     * @param   string $field
     * @param   string $sortOrder
     */
    public function __construct(string $field, string $sortOrder)
    {
        $this->field = $field;

        $sortOrder = Str::lower($sortOrder);
        $availableDirections = [
            'asc',
            'desc',
        ];

        // check if the value is available, otherwise set "default" sort order to ascending!
        if (!in_array($sortOrder, $availableDirections)) {
            $sortOrder = 'asc';
        }

        $this->sortOrder = $sortOrder;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param   $model
     * @param   PrettusRepositoryInterface $repository
     *
     * @return  Builder
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->orderBy($this->field, $this->sortOrder);
    }
}
