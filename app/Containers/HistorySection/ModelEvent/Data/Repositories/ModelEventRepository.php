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

namespace App\Containers\HistorySection\ModelEvent\Data\Repositories;

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent as ModelEventModel;
use App\Ship\Parents\Repositories\Repository;

final class ModelEventRepository extends Repository
{
    public function deleteByModelIds(string $model, array $ids): int
    {
        return $this->deleteWhere([
            [ModelEvent::MODEL, '=', $model],
            [ModelEvent::MODEL_ID, 'in', $ids]
        ]);
    }

    public function model(): string
    {
        return ModelEventModel::class;
    }
}
