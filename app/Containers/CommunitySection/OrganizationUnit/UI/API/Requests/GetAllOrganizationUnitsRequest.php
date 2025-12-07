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

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Requests\OrganizationUnitApiRequest;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers\OrganizationUnitToListTransformer;
use App\Ship\Contracts\IsListableRequest;
use App\Ship\Traits\Request\ListableTransformerRequest;

class GetAllOrganizationUnitsRequest extends OrganizationUnitApiRequest implements IsListableRequest
{
    use ListableTransformerRequest;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function rules(): array
    {
        return $this->priceFromRules();
    }

    public function isOnlyTrashed(): bool
    {
        if (!$this->user()->hasRole(RoleModel::ORGANIZATION_OWNER)) {
            return false;
        }

        return parent::isOnlyTrashed();
    }

    public function getToListTransformer(): OrganizationUnitToListTransformer
    {
        return new OrganizationUnitToListTransformer();
    }
}
