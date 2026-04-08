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

namespace App\Containers\ShiftSection\Shift\Tasks;

use App\Containers\ShiftSection\Shift\Models\Shift;
use Exception;

class PaidShiftsTask extends ShiftTask
{
    public function run(array $ids): int
    {
        $processed = 0;
        foreach ($ids as $id) {
            $result = $this->onItem($id);
            if (!is_null($result)) {
                $processed++;
            }
        }

        return $processed;
    }

    protected function onItem(int $id): ?Shift
    {
        try {
            $shift = $this->repository->find($id);
            if (is_null($shift->payment_at)) {
                return $shift->paid();
            }

            return null;
        } catch (Exception) {
            return null;
        }
    }
}
