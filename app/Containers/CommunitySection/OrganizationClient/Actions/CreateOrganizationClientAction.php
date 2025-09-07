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

use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Dto\CreateOrganizationClientDto;
use App\Containers\CommunitySection\OrganizationClient\Tasks\CreateOrganizationClientTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;

class CreateOrganizationClientAction extends Action
{
    /**
     * @param CreateOrganizationClientDto $dto
     * @return OrganizationClient
     * @throws CreateResourceFailedException
     */
    public function run(CreateOrganizationClientDto $dto): OrganizationClient
    {
        return app(CreateOrganizationClientTask::class)->run($dto);
    }
}
