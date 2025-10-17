<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\HistorySection\ModelNote\Search;

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;
use App\Ship\Search\MutateSearchBuilder;
use Illuminate\Database\Eloquent\Builder;

final class MutateModelNoteSearchBuilder extends MutateSearchBuilder
{
    public function mutate(): Builder
    {
        $eventTable = ModelEvent::TABLE;
        $noteTable = ModelNote::TABLE;

        $joinEventTable = $eventTable . ' as ' . ModelEvent::TABLE;
        $joinFirst = $noteTable . '.' . BaseModelNote::EVENT_ID;
        $joinSecond = $eventTable . '.' . ID;

        return $this->builder
            ->select([
                $noteTable . '.*',
                $eventTable . '.' . BaseModelEvent::TYPE . ' as ' . BaseModelEvent::EVENT_TYPE_ALIAS
            ])
            ->leftJoin(
                $joinEventTable,
                $joinFirst,
                '=',
                $joinSecond
            );
    }
}
