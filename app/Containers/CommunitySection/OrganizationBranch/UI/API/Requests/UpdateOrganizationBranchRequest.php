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
use App\Containers\CommunitySection\OrganizationBranch\Dto\UpdateOrganizationBranchDto;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Exists;

/**
 * @method UpdateOrganizationBranchDto getDto()
 */
class UpdateOrganizationBranchRequest extends CreateOrganizationBranchRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected array $urlParameters = [
        ID
    ];

    protected function afterInitialize(): void
    {
        $this->mergeDecode(ID);
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ID => $this->getOrganizationBranchIdValidationRules()
        ]);
    }

    public function getOrganizationBranchNameValidationRules(): ValidationRules
    {
        return parent::getOrganizationBranchNameValidationRules()
            ->removeRequired();
    }

    public function getOrganizationBranchPhoneNumberValidationRules(): ValidationRules
    {
        return parent::getOrganizationBranchPhoneNumberValidationRules()
            ->removeRequired();
    }

    public function getOrganizationBranchLocationValidationRules(): ValidationRules
    {
        return parent::getOrganizationBranchLocationValidationRules()
            ->removeRequired();
    }

    public function getOrganizationBranchResponsibleByValidationRules(): ValidationRules
    {
        return parent::getOrganizationBranchResponsibleByValidationRules()
            ->removeRequired();
    }

    public function getOrganizationBranchIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationBranchIdValidationRules()
            ->addRequired();
    }

    public function newDto(array $data = []): UpdateOrganizationBranchDto
    {
        return new UpdateOrganizationBranchDto($data);
    }

    protected function prepareForValidationResponsibleBy(): void
    {
        //  No logic for default responsible_by.
    }

    public function getOrganizationBranchIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationBranchIdExistsValidationRule($column)
            ->where(OrganizationBranch::ORGANIZATION_ID, $this->organization_id);
    }

    /**
     * @return bool
     * @throws ValidationFailedException
     * @throws AuthorizationException
     */
    protected function passesAuthorization(): bool
    {
        $result = parent::passesAuthorization();
        if ($result === true) {
            $this->throwIfEmptyInput();
        }

        return $result;
    }

    protected function isOrganizationOwner(): bool
    {
        return $this->user()
            ->isRealOrganizationOwner($this->organization_id);
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }
}
