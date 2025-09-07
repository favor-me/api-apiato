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

namespace App\Containers\CommunitySection\OrganizationClient\Actions;

use App\Containers\CommunitySection\OrganizationClient\Dto\UpdateOrganizationClientDto;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Tasks\UpdateOrganizationClientTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateOrganizationClientAction extends Action
{
    /**
     * @param UpdateOrganizationClientDto $dto
     * @return OrganizationClient
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateOrganizationClientDto $dto): OrganizationClient
    {
        return app(UpdateOrganizationClientTask::class)->run($dto);
    }
}
