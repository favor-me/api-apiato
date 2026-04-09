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

namespace App\Containers\ShiftSection\Item\Actions;

use App\Containers\ShiftSection\Item\Models\Item;
use App\Containers\ShiftSection\Item\Tasks\DeleteItemsTask;
use App\Containers\ShiftSection\Item\Tasks\FindItemsByIdsTask;
use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class DeleteItemsAction extends Action
{
    /**
     * @param array $ids
     * @return int|null
     * @throws NotFoundException
     * @throws RepositoryException
     */
    public function run(array $ids): ?int
    {
        $shifts = $this->getShifts($ids);
        $result = app(DeleteItemsTask::class)->run($ids);

        $shifts
            ->each(
                fn (Shift $shift) => $shift->calculate()->update()
            );

        return $result;
    }

    /**
     * @param array $ids
     * @return Collection
     * @throws RepositoryException
     */
    protected function getShifts(array $ids): Collection
    {
        $shifts = collect();

        app(FindItemsByIdsTask::class)
            ->run($ids)
            ->each(function (Item $item) use (&$shifts) {
                if (!$shifts->has($item->shift_id)) {
                    $shifts->put($item->shift->id, $item->shift);
                }
            });

        return $shifts;
    }
}
