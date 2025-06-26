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

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisBetweenDatesCriteria
 *
 * @package App\Ship\Criterias
 */
class ThisBetweenDatesCriteria extends Criteria
{
    /**
     * Hold start.
     *
     * @var Carbon
     */
    private Carbon $start;

    /**
     * Hold end.
     *
     * @var Carbon
     */
    private Carbon $end;

    /**
     * Hold field.
     *
     * @var string
     */
    private string $field;

    /**
     * ThisBetweenDatesCriteria constructor.
     *
     * @param   string $field
     * @param   Carbon $start
     * @param   Carbon $end
     */
    public function __construct(string $field, Carbon $start, Carbon $end)
    {
        $this->start = $start;
        $this->end = $end;
        $this->field = $field;
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
    public function apply($model, $repository)
    {
        return $model->whereBetween($this->field, [$this->start->toDateString(), $this->end->toDateString()]);
    }
}
