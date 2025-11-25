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
use App\Containers\AppSection\User\Traits\IsOrganizationUser;
use App\Containers\CommunitySection\Organization\Traits\OrganizationValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Traits\OrganizationUnitValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers\OrganizationUnitTransformerManager;
use App\Containers\OrganizationSection\UnitPrice\Traits\UnitPriceValidationRules;
use App\Containers\Vendor\Unit\Traits\HasUnitValidationRules;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

/**
 * @property-read mixed $organization_id
 * @property-read null|int $price_model_id
 */
abstract class OrganizationUnitApiRequest extends ApiRequest implements GettableTransformer
{
    use IsOrganizationUser;
    use HasUnitValidationRules;
    use UnitPriceValidationRules;
    use OrganizationValidationRules;
    use OrganizationUnitValidationRules;

    public const string PRICE_MODEL = 'price_model';
    public const string PRICE_MODEL_ID = 'price_model_id';

    protected array $decode = [
        self::PRICE_MODEL_ID,
        OrganizationUnit::ORGANIZATION_ID
    ];

    public function getTransformer(): Transformer
    {
        return (new OrganizationUnitTransformerManager())
            ->getDefaultOrAdmin();
    }

    public function messages(): array
    {
        return [
            OrganizationUnit::TYPE . '.required' => Container::trans('validation.type.required'),
            OrganizationUnit::NAME . '.required' => Container::trans('validation.name.required'),
            OrganizationUnit::NAME . '.unique' => Container::trans('validation.name.unique'),
            OrganizationUnit::SKU . '.unique' => Container::trans('validation.sku.unique'),
            OrganizationUnit::ORGANIZATION_ID . '.required' => Container::trans('validation.organization_id.required'),
        ];
    }

    public function getPriceModel(): ?string
    {
        return $this->get(self::PRICE_MODEL);
    }

    public function getPriceModelId(): ?int
    {
        return $this->price_model_id;
    }

    protected function priceListRules(): array
    {
        $priceModelRules = $this->getUnitPriceModelValidationRules()
            ->add('required_with:' . self::PRICE_MODEL_ID);

        return [
            self::PRICE_MODEL => $priceModelRules,
            self::PRICE_MODEL_ID => $this->getUnitPriceModelIdValidationRules(),
        ];
    }

    protected function prepareForValidation(): void
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

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationUser'
        ]);
    }
}
