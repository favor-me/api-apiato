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

use App\Containers\OrganizationSection\Shift\Models\Shift;
use App\Containers\OrganizationSection\Shift\Tasks\FindShiftByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

class FindShiftByIdAction extends Action
{
    /**
     * @param int $id
     * @return Shift
     * @throws NotFoundException
     */
    public function run(int $id): Shift
    {
        return app(FindShiftByIdTask::class)->run($id);
    }
}
