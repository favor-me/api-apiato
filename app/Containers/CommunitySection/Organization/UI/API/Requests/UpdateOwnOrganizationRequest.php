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

namespace App\Containers\CommunitySection\Organization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\Organization\Dto\UpdateOrganizationDto;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Unique;

/**
 * @method UpdateOrganizationDto getDto()
 */
class UpdateOwnOrganizationRequest extends CreateOrganizationRequest
{
    use HasInputId;

    protected array $access = [
        RoleModel::ORGANIZATION_OWNER
    ];

    protected array $decode = [
        ID
    ];

    public function rules(): array
    {
        $rules = parent::rules();

        if (array_key_exists(Organization::USER_OWNER_ID, $rules)) {
            unset($rules[Organization::USER_OWNER_ID]);
        }

        return array_merge($rules, [
            ID => $this->getOrganizationIdValidationRules()
        ]);
    }

    public function getOrganizationPhoneNumberValidationRules(): ValidationRules
    {
        return parent::getOrganizationPhoneNumberValidationRules()
            ->removeRequired();
    }

    public function getOrganizationIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationNameUniqueValidationRule(): Unique
    {
        return parent::getOrganizationEmailUniqueValidationRule()
            ->ignore($this->id);
    }

    public function getOrganizationInnUniqueValidationRule(): Unique
    {
        return parent::getOrganizationInnUniqueValidationRule()
            ->ignore($this->id);
    }

    public function getOrganizationPhoneNumberUniqueValidationRule(): Unique
    {
        return parent::getOrganizationPhoneNumberUniqueValidationRule()
            ->ignore($this->id);
    }

    public function getOrganizationEmailValidationRules(): ValidationRules
    {
        return parent::getOrganizationEmailValidationRules()
            ->add('nullable');
    }

    public function getOrganizationInnValidationRules(): ValidationRules
    {
        return parent::getOrganizationInnValidationRules()
            ->add('nullable');
    }

    public function newDto(array $data = []): UpdateOrganizationDto
    {
        return new UpdateOrganizationDto($data);
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->merge([
            ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
        ]);
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

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }

    protected function isOrganizationOwner(): bool
    {
        return $this->user()->isRealOrganizationOwner();
    }
}
