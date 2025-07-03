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
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Traits\IsOwnerTrait;
use App\Ship\Collections\ValidationRulesCollection;
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

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    protected array $decode = [
        ID
    ];

    protected array $urlParameters = [
        ID
    ];

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOwner|isOrganizationOwner'
        ]);
    }

    /**
     * @return bool
     * @throws NotFoundException
     */
    protected function isOrganizationOwner(): bool
    {
        if ($this->user()->id === $this->id) {
            return false;
        }

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

    public function getUserEmailValidationRules(): ValidationRulesCollection
    {
        return parent::getUserEmailValidationRules()
            ->addIgnoreIdForUnique($this->getId());
    }

    public function getUserLoginValidationRules(): ValidationRulesCollection
    {
        return parent::getUserLoginValidationRules()
            ->addIgnoreIdForUnique($this->getId());
    }

    protected function getUserRules(): array
    {
        return array_merge(parent::getUserRules(), [
            ID => $this->getUserIdValidationRules()
        ]);
    }

    public function getUserIdValidationRules(): ValidationRulesCollection
    {
        return parent::getUserIdValidationRules()
            ->addRequired();
    }

    public function getUserPhoneNumberValidationRules(): ValidationRulesCollection
    {
        return parent::getUserPhoneNumberValidationRules()
            ->addIgnoreIdForUnique(
                $this->getId()
            );
    }

    public function rules(): array
    {
        return $this->getUserRules();
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
}
