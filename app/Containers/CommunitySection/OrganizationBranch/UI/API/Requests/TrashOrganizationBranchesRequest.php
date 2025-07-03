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
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Requests\OrganizationBranchApiRequest;
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Traits\Request\HasInputIds;
use Illuminate\Validation\Rules\Exists;

class TrashOrganizationBranchesRequest extends OrganizationBranchApiRequest
{
    use HasInputIds;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected array $decode = [
        IDS . '.*'
    ];

    public function rules(): array
    {
        return [
            IDS . '.*' => $this->getOrganizationBranchIdValidationRules()
        ];
    }

    public function getOrganizationBranchIdValidationRules(): ValidationRulesCollection
    {
        return parent::getOrganizationBranchIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationBranchIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationBranchIdExistsValidationRule($column)
            ->whereNull(DELETED_AT)
            ->where(OrganizationBranch::ORGANIZATION_ID, $this->user()->organization_id);
    }

    protected function isOrganizationOwner(): bool
    {
        return $this->user()->isRealOrganizationOwner();
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }
}
