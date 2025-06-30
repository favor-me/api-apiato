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

namespace App\Containers\CommunitySection\Organization\UI\API\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Containers\CommunitySection\Organization\Dto\RegistrationOrganizationDto;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Ship\Collections\ValidationRulesCollection;
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
        return parent::rules() +
            [
                Organization::OWNER_NAME => $this->getClientValidationRules(),
                User::PASSWORD => $this->getUserPasswordValidationRules()
            ];
    }

    public function messages(): array
    {
        return parent::messages() +
            [
                Organization::OWNER_NAME => Container::trans('validation.owner_name.required')
            ];
    }

    public function getUserPasswordValidationRules(): ValidationRulesCollection
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

    public function getClientValidationRules(): ValidationRulesCollection
    {
        return validation_rules(['required']);
    }
}
