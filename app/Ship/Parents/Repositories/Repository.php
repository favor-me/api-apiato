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

namespace App\Ship\Parents\Repositories;

use Apiato\Core\Abstracts\Repositories\Repository as AbstractRepository;
use App\Ship\Exceptions\InvalidSystemDateFormatException;
use App\Ship\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

abstract class Repository extends AbstractRepository
{
    /**
     * @param mixed $limit
     * @param array $columns
     * @param string $method
     * @return LengthAwarePaginator
     * @throws RepositoryException
     */
    public function paginate($limit = null, $columns = ['*'], $method = 'paginate'): LengthAwarePaginator
    {
        $limit = $this->setPaginationLimit($limit);
        return $this->cacheablePaginate($limit, $columns, $method);
    }

    /**
     * @param mixed $limit
     * @return null|int
     * @throws RepositoryException
     */
    public function setPaginationLimit(mixed $limit): ?int
    {
        if ($limit === '*' || request()->input('limit') == '*') {
            $repository = clone $this;

            $repository->applyCriteria();
            $repository->applyScope();

            $count = $this->count();

            $repository->resetModel();
            $repository->resetCriteria();
            $repository->resetScope();

            return $count;
        }

        return parent::setPaginationLimit($limit);
    }

    /**
     * @param mixed|null $date
     * @return array|array[]
     * @throws InvalidSystemDateFormatException
     */
    protected function getDateWhere(string $field, mixed $date = null): array
    {
        if (is_array($date) && count($date) > 1) {
            list($fromDate, $toDate) = $date;
            return [
                [$field, 'date >=', $fromDate],
                [$field, 'date <=', $toDate]
            ];
        }

        $where = [];
        if (!is_null($date)) {
            if ($date === KEY_NOW) {
                $date = Carbon::now();
            } elseif ($date === KEY_YESTERDAY) {
                $date = Carbon::yesterday();
            } elseif ($date === KEY_TOMORROW) {
                $date = Carbon::tomorrow();
            }

            if (is_string($date)) {
                $date = Carbon::createFromSystemDate($date);
            }

            $where[] = [$field, 'date', $date];
        }

        return $where;
    }
}
