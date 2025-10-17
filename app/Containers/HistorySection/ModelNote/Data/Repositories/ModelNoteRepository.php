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

namespace App\Containers\HistorySection\ModelNote\Data\Repositories;

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;
use App\Containers\HistorySection\ModelNote\Search\EventTypeAliasSearch;
use App\Containers\HistorySection\ModelNote\Search\MutateModelNoteSearchBuilder;
use App\Ship\Contracts\Database\Eloquent\MutateSearchBuilder;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Search\DateTimeRangeSearch;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method ModelNote getModel()
 */
class ModelNoteRepository extends Repository implements MutateSearchBuilder
{
    protected $fieldSearchable = [
        ID => 'in',
        BaseModelNote::TYPE => '=',
        BaseModelNote::MODEL => '=',
        BaseModelEvent::EVENT_TYPE_ALIAS => EventTypeAliasSearch::class,
        BaseModelNote::MODEL_ID => 'in',
        BaseModelNote::EVENT_ID => 'in',
        CREATED_BY => '=',
        CREATED_AT => DateTimeRangeSearch::class
    ];

    public function deleteByModelIds(string $model, array $ids): int
    {
        return $this->deleteWhere([
            [BaseModelNote::MODEL, '=', $model],
            [BaseModelNote::MODEL_ID, 'in', $ids]
        ]);
    }

    public function mutateSearchBuilder($builder, array $searchData = []): Builder
    {
        return (new MutateModelNoteSearchBuilder($builder, $searchData))->mutate();
    }

    public function model(): string
    {
        return ModelNote::class;
    }
}
