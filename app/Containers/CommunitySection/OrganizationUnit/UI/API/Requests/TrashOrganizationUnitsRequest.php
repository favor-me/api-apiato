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
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Requests\OrganizationUnitApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputIds;
use Illuminate\Validation\Rules\Exists;

class TrashOrganizationUnitsRequest extends OrganizationUnitApiRequest
{
    use HasInputIds;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(IDS . '.*');
    }

    public function rules(): array
    {
        return [
            IDS . '.*' => $this->getOrganizationUnitIdValidationRules()
        ];
    }

    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationUnitIdExistsValidationRule($column)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->organization_id);
    }
}
