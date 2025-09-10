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

namespace App\Containers\CommunitySection\OrganizationUnit\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\Organization\Traits\OrganizationValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Traits\OrganizationUnitValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers\AdminOrganizationUnitTransformer;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers\OrganizationUnitTransformer;
use App\Containers\Vendor\Unit\Traits\HasUnitValidationRules;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

abstract class OrganizationUnitApiRequest extends ApiRequest implements GettableTransformer
{
    use HasUnitValidationRules;
    use OrganizationValidationRules;
    use OrganizationUnitValidationRules;

    protected array $decode = [
        OrganizationUnit::ORGANIZATION_ID
    ];

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminOrganizationUnitTransformer() : new OrganizationUnitTransformer();
    }

    public function messages(): array
    {
        return [
            OrganizationUnit::TYPE . '.required' => Container::trans('validation.type.required'),
            OrganizationUnit::NAME . '.required' => Container::trans('validation.name.required'),
            OrganizationUnit::ORGANIZATION_ID . '.required' => Container::trans('validation.organization_id.required'),
        ];
    }

    protected function prepareForValidation()
    {
        $this->prepareForValidationOrganizationId();
    }

    protected function prepareForValidationOrganizationId(): void
    {
        if (!is_null($this->user())) {
            $this->merge([
                OrganizationUnit::ORGANIZATION_ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
            ]);
        }
    }
}
