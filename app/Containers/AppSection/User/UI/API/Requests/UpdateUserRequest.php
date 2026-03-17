<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Dto\UpdateUserDto;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Containers\AppSection\User\ShiftParams\Schema;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Traits\IsOrganizationOwner;
use App\Containers\AppSection\User\Traits\IsOwnerTrait;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Traits\Request\HasInputId;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Ship\Exceptions\NotFoundException;

/**
 * @method UserModel user($guard = null)
 */
class UpdateUserRequest extends UserApiRequest implements GettableDto
{
    use HasInputId;
    use IsOwnerTrait;
    use IsOrganizationOwner;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    protected array $decode = [
        ID,
        User::ORGANIZATION_BRANCH_ID
    ];

    protected array $urlParameters = [
        ID
    ];

    public function getUserEmailValidationRules(): ValidationRules
    {
        return parent::getUserEmailValidationRules()
            ->addIgnoreIdForUnique($this->getId());
    }

    public function getUserLoginValidationRules(): ValidationRules
    {
        return parent::getUserLoginValidationRules()
            ->addIgnoreIdForUnique($this->getId());
    }

    public function getUserOrganizationBranchIdValidationRules(): ValidationRules
    {
        return validation_rules([
            'nullable',
            $this->getUserExistsInOrganizationBranchIdValidationRule(
                $this->user()->organization_id
            )
        ]);
    }

    public function getUserIdValidationRules(): ValidationRules
    {
        return parent::getUserIdValidationRules()
            ->addRequired();
    }

    public function getUserPhoneNumberValidationRules(): ValidationRules
    {
        return parent::getUserPhoneNumberValidationRules()
            ->addIgnoreIdForUnique(
                $this->getId()
            );
    }

    /**
     * @return array
     * @throws NotFoundException
     */
    public function rules(): array
    {
        return $this->getUserRules();
    }

    public function messages(): array
    {
        return parent::messages() + Schema::getElementsValidationRuleMessages();
    }

    /**
     * @return UpdateUserDto
     * @throws UnknownProperties
     */
    public function getDto(): UpdateUserDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return UpdateUserDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): UpdateUserDto
    {
        return new UpdateUserDto($data);
    }

    /**
     * @return array
     * @throws NotFoundException
     */
    protected function getUserRules(): array
    {
        $rules = parent::getUserRules();

        if (!$this->isOrganizationOwner()) {
            unset($rules[User::SHIFT_PARAMS]);
        } else {
            $rules += Schema::getElementsValidationRules();
        }

        return array_merge($rules, [
            ID => $this->getUserIdValidationRules(),
            User::ORGANIZATION_BRANCH_ID => $this->getUserOrganizationBranchIdValidationRules()
        ]);
    }

    /**
     * @return bool
     * @throws NotFoundException
     */
    protected function isOrganizationOwner(): bool
    {
        $updatingUser = app(FindUserByIdTask::class)
            ->setColumns([
                ID,
                User::ORGANIZATION_ID
            ])
            ->run($this->id);

        if (!is_null($updatingUser)) {
            return $this->user()
                ->isRealOrganizationOwner(
                    $updatingUser->organization_id
                );
        }

        return false;
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOwner|isOrganizationOwner'
        ]);
    }
}
