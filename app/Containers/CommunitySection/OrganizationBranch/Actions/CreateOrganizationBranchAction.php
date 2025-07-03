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

namespace App\Containers\CommunitySection\OrganizationBranch\Actions;

use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Dto\CreateOrganizationBranchDto;
use App\Containers\CommunitySection\OrganizationBranch\Tasks\CreateOrganizationBranchTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;

class CreateOrganizationBranchAction extends Action
{
    /**
     * @param CreateOrganizationBranchDto $dto
     * @return OrganizationBranch
     * @throws CreateResourceFailedException
     */
    public function run(CreateOrganizationBranchDto $dto): OrganizationBranch
    {
        return app(CreateOrganizationBranchTask::class)->run($dto);
    }
}
