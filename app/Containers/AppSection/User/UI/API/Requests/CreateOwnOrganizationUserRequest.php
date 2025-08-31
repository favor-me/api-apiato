<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\IsOrganizationOwner;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;

/**
 * @property-read mixed $organization_id
 */
class CreateOwnOrganizationUserRequest extends RegisterUserRequest
{
    use IsOrganizationOwner;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected array $decode = [
        User::ORGANIZATION_ID,
        User::ORGANIZATION_BRANCH_ID
    ];

    public function getUserOrganizationBranchIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getUserExistsInOrganizationBranchIdValidationRule($this->organization_id)
        ])->addRequired();
    }

    public function getUserOrganizationIdValidationRules(): ValidationRules
    {
        return validation_rules([])
            ->addRequired();
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->merge([
            User::ORGANIZATION_ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
        ]);
    }

    protected function getUserRules(): array
    {
        return parent::getUserRules() +
            [
                User::ORGANIZATION_ID => $this->getUserOrganizationIdValidationRules(),
                User::ORGANIZATION_BRANCH_ID => $this->getUserOrganizationBranchIdValidationRules()
            ];
    }

    protected function getDtoData(): array
    {
        return parent::getDtoData() +
            [
                'role' => RoleModel::ORGANIZATION_WORKER
            ];
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }
}
