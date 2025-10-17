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

use App\Ship\Contracts\Database\Eloquent\MutateSearchBuilder;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria as BaseRequestCriteria;

/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
class RequestCriteria extends BaseRequestCriteria
{
    public const DEFAULT_SORTED_BY = 'asc';
    public const LOGIC_AND = 'and';
    public const LOGIC_OR = 'or';

    protected ?string $filter;
    protected ?string $orderBy;
    protected ?string $search;
    protected ?string $searchFields;
    protected ?string $searchJoin;
    protected ?string $sortedBy;
    protected ?string $with;
    protected ?string $withCount;
    protected bool $isFirstField = true;

    public function apply($model, RepositoryInterface $repository)
    {
        $this->initProperties();

        $fieldsSearchable = $repository->getFieldsSearchable();

        if ($this->canSearchable($fieldsSearchable)) {
            $model = $this->setModelWhere($model, $fieldsSearchable);
        }

        $this->setOrderBy($model);
        $this->setFilter($model);
        $this->setWith($model);
        $this->setWithCount($model);

        if (is_subclass_of($repository, MutateSearchBuilder::class)) {
            $searchData = $this->parserSearchData($this->search);
            $model = $repository->mutateSearchBuilder($model, (array)$searchData);
        }

        return $model;
    }

    protected function canSearchable(array $fieldsSearchable): bool
    {
        return !empty($this->search) && is_array($fieldsSearchable) && count($fieldsSearchable);
    }

    protected function checkFieldConditionBetween(&$value, string $condition): self
    {
        if ($this->isBetweenCondition($condition)) {
            $value = explode(',', $value);
            if (count($value) < 2) {
                $value = null;
            }
        }

        return $this;
    }

    protected function checkFieldConditionIn(string &$field, &$value, string $condition): self
    {
        if ($this->isInCondition($condition)) {
            $value = explode(',', $value);
            if (trim($value[0]) === "" || $field == $value[0]) {
                $value = null;
            }
        }

        return $this;
    }

    protected function checkFieldLevel(string &$field, &$relation): self
    {
        if (stripos($field, '.')) {
            $explode = explode('.', $field);
            $field = array_pop($explode);
            $relation = implode('.', $explode);
        }

        return $this;
    }

    /**
     * @param string|null $field
     * @param string|null $condition
     * @param string|null $search
     * @param array $searchData
     * @return mixed|string|null
     */
    protected function getFieldValue(?string $field, ?string $condition, ?string $search, array $searchData)
    {
        $value = null;

        if (isset($searchData[$field])) {
            $value = $this->isLikeCondition($condition) ? "%{$searchData[$field]}%" : $searchData[$field];
        } else {
            if (!is_null($search) && !in_array($condition, ['in', 'between'])) {
                $value = $this->isLikeCondition($condition) ? "%{$search}%" : $search;
            }
        }

        return $value;
    }

    /**
     * @return array|string|null
     */
    protected function getSearchFields()
    {
        return is_array($this->searchFields) || is_null($this->searchFields) ?
            $this->searchFields : explode(';', $this->searchFields);
    }

    protected function initProperties(): void
    {
        $configKey = 'repository.criteria.params';

        $this->sortedBy = $this->request->get(
            config("{$configKey}.sortedBy", 'sortedBy'),
            self::DEFAULT_SORTED_BY
        );

        $this->search = $this->request->get(config("{$configKey}.search", 'search'), null);
        $this->searchFields = $this->request->get(config("{$configKey}.searchFields", 'searchFields'), null);
        $this->filter = $this->request->get(config("{$configKey}.filter", 'filter'), null);
        $this->orderBy = $this->request->get(config("{$configKey}.orderBy", 'orderBy'), null);
        $this->with = $this->request->get(config("{$configKey}.with", 'with'), null);
        $this->withCount = $this->request->get(config("{$configKey}.withCount", 'withCount'), null);
        $this->searchJoin = $this->request->get(config("{$configKey}.searchJoin", 'searchJoin'), null);
        $this->sortedBy = !empty($this->sortedBy) ? $this->sortedBy : self::DEFAULT_SORTED_BY;
    }

    protected function isBetweenCondition(?string $condition): bool
    {
        return $condition === 'between';
    }

    protected function isCallableCondition(?string $condition): bool
    {
        return $condition === 'callable';
    }

    protected function isClassCondition(?string $condition): bool
    {
        return $condition === 'class';
    }

    protected function isInCondition(?string $condition): bool
    {
        return $condition === 'in';
    }

    protected function isLikeCondition(?string $condition): bool
    {
        return $condition == 'like' || $condition == 'ilike';
    }

    /**
     * @param Builder $model
     */
    protected function setFilter(&$model): void
    {
        $filter = $this->filter;

        if (isset($filter) && !empty($filter)) {
            if (is_string($filter)) {
                $filter = explode(';', $filter);
            }

            $model = $model->select($filter);
        }
    }

    /**
     * @param Builder $query
     * @param string|null $field
     * @param mixed $value
     * @param string|null $condition
     */
    protected function setForceAndWhereConditions(&$query, ?string $field, $value, ?string $condition): void
    {
        $modelTableName = $query->getModel()->getTable();

        if ($this->isInCondition($condition)) {
            $query->whereIn("{$modelTableName}.{$field}", $value);
        } elseif ($this->isBetweenCondition($condition)) {
            $query->whereBetween("{$modelTableName}.{$field}", $value);
        } else {
            $query->where("{$modelTableName}.{$field}", $condition, $value);
        }
    }

    /**
     * @param Builder $query
     * @param string|null $relation
     * @param string|null $field
     * @param string|null $condition
     * @param mixed $value
     */
    protected function setForceAndWhereConditionsForRelation(
        &$query,
        ?string $relation,
        ?string $field,
        ?string $condition,
        $value
    ): void {
        $criteria = $this;
        $query->whereHas($relation, function ($query) use ($field, $condition, $value, $criteria) {
            if ($criteria->isInCondition($condition)) {
                $query->whereIn($field, $value);
            } elseif ($criteria->isBetweenCondition($condition)) {
                $query->whereBetween($field, $value);
            } else {
                $query->where($field, $condition, $value);
            }
        });
    }

    /**
     * @param Builder $query
     * @param string|null $field
     * @param mixed $value
     * @param string|null $condition
     */
    protected function setForceOrWhereConditions(&$query, ?string $field, $value, ?string $condition): void
    {
        $modelTableName = $query->getModel()->getTable();

        if ($this->isInCondition($condition)) {
            $query->orWhereIn("{$modelTableName}.{$field}", $value);
        } elseif ($this->isBetweenCondition($condition)) {
            $query->whereBetween("{$modelTableName}.{$field}", $value);
        } else {
            $query->orWhere("{$modelTableName}.{$field}", $condition, $value);
        }
    }

    /**
     * @param Builder $query
     * @param string|null $relation
     * @param mixed $field
     * @param string|null $condition
     * @param string $value
     */
    protected function setForceOrWhereConditionsForRelation(
        &$query,
        ?string $relation,
        $field,
        ?string $condition,
        string $value
    ): void {
        $criteria = $this;
        $query->orWhereHas($relation, function ($query) use ($field, $condition, $value, $criteria) {
            if ($criteria->isInCondition($condition)) {
                $query->whereIn($field, $value);
            } elseif ($this->isBetweenCondition($criteria)) {
                $query->whereBetween($field, $value);
            } else {
                $query->where($field, $condition, $value);
            }
        });
    }

    /**
     * @param $model
     * @param array $fieldsSearchable
     * @return Builder
     * @throws Exception
     */
    protected function setModelWhere($model, array $fieldsSearchable = []): Builder
    {
        $searchFields = $this->getSearchFields();
        $searchData = $this->parserSearchData($this->search);
        $search = $this->parserSearchValue($this->search);
        $fields = $this->parserFieldsSearch($fieldsSearchable, $searchFields, array_keys($searchData));

        $modelForceAndWhere = strtolower($this->searchJoin) === 'and';

        return $model->where(function ($query) use ($fields, $search, $searchData, $modelForceAndWhere) {
            foreach ($fields as $field => $condition) {
                $this->setModelWhereForField(
                    $query,
                    $field,
                    $condition,
                    $search,
                    $searchData,
                    $modelForceAndWhere
                );
            }
        });
    }

    /**
     * @param Builder $query
     * @param string $field
     * @param mixed $condition
     * @param $search
     * @param array $searchData
     * @param bool $modelForceAndWhere
     */
    protected function setModelWhereForField(
        &$query,
        string $field,
        $condition,
        $search,
        array $searchData,
        bool $modelForceAndWhere
    ): void {
        $className = $condition;
        if (is_string($condition) && class_exists($condition)) {
            $condition = 'class';
        }

        $callback = $condition;
        if (is_callable($condition)) {
            $condition = 'callable';
        }

        if (is_numeric($field)) {
            $field = $condition;
            $condition = '=';
        }

        $relation = null;
        $condition = trim(strtolower($condition));
        $value = $this->getFieldValue($field, $condition, $search, $searchData);

        $this
            ->checkFieldLevel($field, $relation)
            ->checkFieldConditionIn($field, $value, $condition)
            ->checkFieldConditionBetween($value, $condition);

        //  TODO Please a need refactor.
        if ($this->isFirstField || $modelForceAndWhere) {
            if (!is_null($value)) {
                if (!is_null($relation)) {
                    $this->setForceAndWhereConditionsForRelation($query, $relation, $field, $condition, $value);
                } else {
                    if ($this->isCallableCondition($condition)) {
                        call_user_func_array($callback, [&$query, $field, $value, 'and']);
                    } elseif ($this->isClassCondition($condition)) {
                        app($className, [
                            'query' => $query,
                            'field' => $field,
                            'value' => $value,
                            'whereMode' => 'and'
                        ])();
                    } else {
                        $this->setForceAndWhereConditions($query, $field, $value, $condition);
                    }
                }

                $this->isFirstField = false;
            }
        } else {
            if (!is_null($value)) {
                if (!is_null($relation)) {
                    $this->setForceOrWhereConditionsForRelation($query, $relation, $field, $condition, $value);
                } else {
                    if ($this->isCallableCondition($condition)) {
                        call_user_func_array($callback, [&$query, $field, $value, 'or']);
                    } elseif ($this->isClassCondition($condition)) {
                        app($className, [
                            'query' => $query,
                            'field' => $field,
                            'value' => $value,
                            'whereMode' => 'or'
                        ])();
                    } else {
                        $this->setForceOrWhereConditions($query, $field, $value, $condition);
                    }
                }
            }
        }
    }

    /**
     * @param Builder $model
     */
    protected function setOrderBy(&$model): void
    {
        $orderBy = $this->orderBy;
        $sortedBy = $this->sortedBy;

        if (isset($orderBy) && !empty($orderBy)) {
            $orderBySplit = explode(';', $orderBy);
            if (count($orderBySplit) > 1) {
                $sortedBySplit = explode(';', $sortedBy);
                foreach ($orderBySplit as $orderBySplitItemKey => $orderBySplitItem) {
                    $sortedBy = isset($sortedBySplit[$orderBySplitItemKey])
                        ? $sortedBySplit[$orderBySplitItemKey] : $sortedBySplit[0];
                    $model = $this->parserFieldsOrderBy($model, $orderBySplitItem, $sortedBy);
                }
            } else {
                $model = $this->parserFieldsOrderBy($model, $orderBySplit[0], $sortedBy);
            }
        }
    }

    /**
     * @param Builder $model
     */
    protected function setWith(&$model): void
    {
        $with = $this->with;
        if ($with) {
            $with = explode(';', $with);
            $model = $model->with($with);
        }
    }

    /**
     * @param Builder $model
     */
    protected function setWithCount(&$model): void
    {
        $withCount = $this->withCount;
        if ($withCount) {
            $withCount = explode(';', $withCount);
            $model = $model->withCount($withCount);
        }
    }
}
