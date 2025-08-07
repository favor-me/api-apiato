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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests;

use App\Containers\CommunitySection\OrganizationUnit\Permissions\Permissions;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;

class DeleteOrganizationUnitsRequest extends TrashOrganizationUnitsRequest
{
    protected array $access = [
        PERMISSIONS => Permissions::DELETE
    ];

    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return validation_rules([
            Rule::exists(OrganizationUnitModel::TABLE, ID)
                ->whereNotNull(DELETED_AT)
        ])->addRequired();
    }
}
