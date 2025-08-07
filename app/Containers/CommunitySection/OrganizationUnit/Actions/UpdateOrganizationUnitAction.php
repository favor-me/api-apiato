<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Actions;

use App\Containers\CommunitySection\OrganizationUnit\Dto\UpdateOrganizationUnitDto;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\UpdateOrganizationUnitTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateOrganizationUnitAction extends Action
{
    /**
     * @param UpdateOrganizationUnitDto $dto
     * @return OrganizationUnit
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateOrganizationUnitDto $dto): OrganizationUnit
    {
        return app(UpdateOrganizationUnitTask::class)->run($dto);
    }
}
