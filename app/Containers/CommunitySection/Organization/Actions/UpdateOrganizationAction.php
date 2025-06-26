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

namespace App\Containers\CommunitySection\Organization\Actions;

use App\Containers\CommunitySection\Organization\Dto\UpdateOrganizationDto;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\Organization\Tasks\UpdateOrganizationTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateOrganizationAction extends Action
{
    /**
     * @param UpdateOrganizationDto $dto
     * @return Organization
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateOrganizationDto $dto): Organization
    {
        return app(UpdateOrganizationTask::class)->run($dto);
    }
}
