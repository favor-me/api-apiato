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

namespace App\Containers\CommunitySection\OrganizationBranch\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Validation\Rule;

class DeleteOrganizationBranchesRequest extends TrashOrganizationBranchesRequest
{
    protected array $access = [
        ROLES => RoleModel::ADMIN
    ];

    public function getOrganizationBranchIdValidationRules(): ValidationRulesCollection
    {
        return validation_rules([
            Rule::exists(OrganizationBranchModel::TABLE, ID)
                ->whereNotNull(DELETED_AT)
        ])->addRequired();
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return [
            'hasAccess'
        ];
    }
}
