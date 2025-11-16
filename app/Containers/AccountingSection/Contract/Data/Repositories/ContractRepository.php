<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\AccountingSection\Contract\Data\Repositories;

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Ship\Contracts\Database\Eloquent\MutateSearchBuilder;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @method ContractModel getModel()
 */
final class ContractRepository extends Repository implements MutateSearchBuilder
{
    protected $fieldSearchable = [
        ID => '=',
        Contract::NAME => 'like',
        Contract::NUMBER => '='
    ];

    public function model(): string
    {
        return ContractModel::class;
    }

    /**
     * @param Builder $builder
     * @param array $searchData
     * @return Model|Builder
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function mutateSearchBuilder($builder, array $searchData = []): Model|Builder
    {
        if (request()->get('only') === 'live-now') {
            $now = Carbon::now();
            $value = $now->toDateString();
            return $builder->whereRaw(
                '\'' . $value . '\' >= date(' . Contract::START_AT . ')' .
                ' and ' .
                '\'' . $value . '\' <= date(' . Contract::FINISH_AT . ')'
            );
        }

        return $builder;
    }
}
