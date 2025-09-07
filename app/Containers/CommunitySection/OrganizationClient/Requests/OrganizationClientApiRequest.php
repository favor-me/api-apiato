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

namespace App\Containers\CommunitySection\OrganizationClient\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\Organization\Traits\OrganizationValidationRules;
use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Traits\OrganizationClientValidationRules;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Transformers\AdminOrganizationClientTransformer;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Transformers\OrganizationClientTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;
use App\Ship\Collections\ValidationRules;

/**
 * @property-read mixed $organization_id
 */
abstract class OrganizationClientApiRequest extends ApiRequest implements GettableTransformer
{
    use OrganizationValidationRules;
    use OrganizationClientValidationRules;

    protected array $decode = [
        OrganizationClient::ORGANIZATION_ID
    ];

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminOrganizationClientTransformer() : new OrganizationClientTransformer();
    }

    public function messages(): array
    {
        return [
            OrganizationClient::PHONE_NUMBER . '.unique' => Container::trans('validation.phone_number.unique')
        ];
    }

    public function getOrganizationClientOrganizationIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getOrganizationIdExistsValidationRule(ID)
        ])->addRequired();
    }

    protected function prepareForValidation(): void
    {
        $this->prepareOrganizationIdForValidation();
    }

    protected function prepareOrganizationIdForValidation(): void
    {
        $this->merge([
            OrganizationClient::ORGANIZATION_ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
        ]);
    }
}
