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

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Dto\CreateOrganizationUnitDto;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\CreateOrganizationUnitTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;

class CreateOrganizationUnitAction extends Action
{
    /**
     * @param CreateOrganizationUnitDto $dto
     * @return OrganizationUnit
     * @throws CreateResourceFailedException
     */
    public function run(CreateOrganizationUnitDto $dto): OrganizationUnit
    {
        return app(CreateOrganizationUnitTask::class)->run($dto);
    }
}
