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

namespace App\Containers\OrganizationSection\UnitPrice\Actions;

use App\Containers\OrganizationSection\UnitPrice\Map\Type;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllUnitPricesAction extends Action
{
    /**
     * @param Type $modelType
     * @param mixed $modelId
     * @param mixed|null $limit
     * @return Collection|LengthAwarePaginator
     */
    public function run(Type $modelType, mixed $modelId, mixed $limit = null): Collection|LengthAwarePaginator
    {
        $relation = $modelType
            ->findModel($modelId)
            ->unitPrices();

        if ($limit === '*') {
            return $relation->get();
        }

        return $relation->paginate();
    }
}
