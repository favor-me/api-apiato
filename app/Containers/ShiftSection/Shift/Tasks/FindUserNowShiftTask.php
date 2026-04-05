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

use App\Containers\ShiftSection\Shift\Data\Criterials\NowUserShiftCriteria;
use App\Containers\ShiftSection\Shift\Models\Shift;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Exceptions\RepositoryException;

class FindUserNowShiftTask extends ShiftTask
{
    /**
     * @param mixed|null $userId
     * @return Shift|null
     * @throws RepositoryException
     */
    public function run(mixed $userId = null): ?Shift
    {
        if (is_null($userId) && !is_null(Auth::user())) {
            $userId = Auth::user()->id;
        }

        return $this->repository
            ->pushCriteria(
                new NowUserShiftCriteria($userId)
            )
            ->first();
    }
}
