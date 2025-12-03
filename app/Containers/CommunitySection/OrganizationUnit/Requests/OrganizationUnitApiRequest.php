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

namespace App\Containers\CommunitySection\OrganizationUnit\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\IsOrganizationUser;
use App\Containers\CommunitySection\Organization\Traits\OrganizationValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Traits\OrganizationUnitValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers\OrganizationUnitTransformerManager;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
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

    public const string PRICE_FROM = 'price_from';
    public const string PRICE_FROM_CLEAR = 'price_from_clear';

    protected array $decode = [
        OrganizationUnit::ORGANIZATION_ID,
        self::PRICE_FROM_CLEAR . '.*.' . UnitPrice::MODEL_ID
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

    public function getPriceFrom(): array
    {
        return (array)$this->validated(self::PRICE_FROM_CLEAR);
    }

    protected function priceFromRules(): array
    {
        return [
            self::PRICE_FROM_CLEAR . '.*.' . UnitPrice::MODEL => $this->getUnitPriceModelValidationRules(),
            self::PRICE_FROM_CLEAR . '.*.' . UnitPrice::MODEL_ID => $this->getUnitPriceModelIdValidationRules()
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationOrganizationId();
        $this->prepareForValidationPrice();
    }

    protected function prepareForValidationPrice(): void
    {
        if ($this->has(self::PRICE_FROM)) {
            $prices = explode(';', $this->get(self::PRICE_FROM));

            $clearPrices = collect($prices)
                ->map(function (string $price) {
                    list($model, $id) = explode(':', $price, 2);
                    return [
                        UnitPrice::MODEL => $model,
                        UnitPrice::MODEL_ID => $id
                    ];
                });

            $this->merge([
                self::PRICE_FROM_CLEAR => $clearPrices->toArray()
            ]);
        }
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
