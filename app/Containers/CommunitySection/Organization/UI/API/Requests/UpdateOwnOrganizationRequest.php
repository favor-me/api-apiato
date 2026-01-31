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
use App\Containers\CommunitySection\Counterparty\Countries\Country;
use App\Containers\CommunitySection\Organization\Dto\UpdateOrganizationDto;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tasks\FindOrganizationByIdTask;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Unique;
use JBZoo\Data\JSON;

/**
 * @property-read mixed $bank_data
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
        return validation_rules([
            $this->getOrganizationPhoneNumberUniqueValidationRule(),
            $this->getOrganizationPhoneNumberValidationRule()
        ]);
    }

    public function getOrganizationIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationIdValidationRules()
            ->addRequired();
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

    public function getOrganizationOwnershipTypeValidationRules(): ValidationRules
    {
        return parent::getOrganizationOwnershipTypeValidationRules()
            ->removeRequired();
    }

    public function getOrganizationEmailUniqueValidationRule(): Unique
    {
        return parent::getOrganizationEmailUniqueValidationRule()
            ->ignore($this->id);
    }

    public function newDto(array $data = []): UpdateOrganizationDto
    {
        return new UpdateOrganizationDto($data);
    }

    /**
     * @return void
     * @throws NotFoundException
     */
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->merge([
            ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
        ]);

        $this->prepareForValidationBankData();
    }

    protected function getBankData(): ?JSON
    {
        return new JSON($this->bank_data);
    }

    protected function getFindBankDataModel(): ?OrganizationModel
    {
        if (is_null($this->id)) {
            return null;
        }

        try {
            return app(FindOrganizationByIdTask::class)->run($this->id);
        } catch (NotFoundException) {
            return null;
        }
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

    protected function getCountry(): ?Country
    {
        $country = parent::getCountry();

        if (!is_null($country)) {
            return $country
                ->setContext(OrganizationModel::class)
                ->setIgnoreValue($this->id);
        }

        return null;
    }

    protected function isOrganizationOwner(): bool
    {
        return $this->user()->isRealOrganizationOwner();
    }
}
