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

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Containers\CommunitySection\Organization\Dto\RegistrationOrganizationDto;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Validation\Rules\IsOwnerNameRule;
use App\Containers\OrganizationSection\OwnershipType\Manager;
use App\Containers\OrganizationSection\OwnershipType\OooType;
use App\Ship\Collections\ValidationRules;
use App\Ship\Parents\Transformers\Transformer;

/**
 * @method RegistrationOrganizationDto getDto()
 */
class RegistrationOrganizationRequest extends CreateOrganizationRequest
{
    use HasUserValidationRules {
        HasUserValidationRules::getUserPasswordValidationRules as baseUserPasswordValidationRules;
    }

    protected array $access = [];

    public function rules(): array
    {
        $rules = parent::rules();

        if (array_key_exists(Organization::USER_OWNER_ID, $rules)) {
            unset($rules[Organization::USER_OWNER_ID]);
        }

        return $rules +
            [
                Organization::OWNER_NAME => $this->getClientValidationRules(),
                User::PASSWORD => $this->getUserPasswordValidationRules()
            ];
    }

    public function messages(): array
    {
        return parent::messages() +
            [
                Organization::OWNER_NAME . '.required' => Container::trans('validation.owner_name.required')
            ];
    }

    public function getUserPasswordValidationRules(): ValidationRules
    {
        return $this->baseUserPasswordValidationRules()
            ->addRequired();
    }

    public function newDto(array $data = []): RegistrationOrganizationDto
    {
        return new RegistrationOrganizationDto($data);
    }

    public function getTransformer(): Transformer
    {
        return parent::getTransformer()
            ->addDefaultIncludes(Organization::INCLUDE_USER_OWNER);
    }

    public function getClientValidationRules(): ValidationRules
    {
        return validation_rules([
            'required',
            new IsOwnerNameRule()
        ]);
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationName();
        parent::prepareForValidation();
    }

    protected function getBankDataSchema(array &$rules): void
    {
    }

    protected function prepareForValidationName(): void
    {
        $oooType = Manager::getInstance()->get(OooType::class);
        if ($this->get(Organization::OWNERSHIP_TYPE) !== $oooType->getName()) {
            $this->merge([
                Organization::NAME => str_replace('|', ' ', $this->get(Organization::OWNER_NAME))
            ]);
        }
    }
}
