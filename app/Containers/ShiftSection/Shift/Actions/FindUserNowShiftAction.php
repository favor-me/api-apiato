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

namespace App\Containers\ShiftSection\Shift\Actions;

use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Containers\ShiftSection\Shift\Tasks\FindUserNowShiftTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class FindUserNowShiftAction extends Action
{
    /**
     * @param mixed|null $userId
     * @return Shift|null
     * @throws RepositoryException
     */
    public function run(mixed $userId = null): ?Shift
    {
        return app(FindUserNowShiftTask::class)->run($userId);
    }
}
