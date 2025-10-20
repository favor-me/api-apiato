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

namespace App\Ship\Search;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class MutateSearchBuilder
{
    protected Collection $searchData;

    public function __construct(
        protected Builder|Model $builder,
        array $searchData = []
    ) {
        $this->searchData = collect($searchData);
    }

    abstract public function mutate(): Builder;
}
