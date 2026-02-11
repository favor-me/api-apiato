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

namespace App\Containers\OrganizationSection\Shift\Actions;

use App\Containers\OrganizationSection\Shift\Tasks\RestoreShiftsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\NotFoundException;

class RestoreShiftsAction extends Action
{
    /**
     * @param array $ids
     * @return int
     * @throws NotFoundException
     */
    public function run(array $ids): int
    {
        return app(RestoreShiftsTask::class)->run($ids);
    }
}
