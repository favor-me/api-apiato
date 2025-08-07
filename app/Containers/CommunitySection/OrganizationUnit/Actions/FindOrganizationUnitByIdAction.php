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
use App\Containers\CommunitySection\OrganizationUnit\Tasks\FindOrganizationUnitByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

class FindOrganizationUnitByIdAction extends Action
{
    /**
     * @param int $id
     * @return OrganizationUnit
     * @throws NotFoundException
     */
    public function run(int $id): OrganizationUnit
    {
        return app(FindOrganizationUnitByIdTask::class)->run($id);
    }
}
