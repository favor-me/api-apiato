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

use App\Containers\OrganizationSection\Shift\Dto\UpdateShiftDto;
use App\Containers\OrganizationSection\Shift\Models\Shift;
use App\Containers\OrganizationSection\Shift\Tasks\UpdateShiftTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateShiftAction extends Action
{
    /**
     * @param UpdateShiftDto $dto
     * @return Shift
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateShiftDto $dto): Shift
    {
        return app(UpdateShiftTask::class)->run($dto);
    }
}
