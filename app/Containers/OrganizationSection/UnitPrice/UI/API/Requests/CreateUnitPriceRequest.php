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

namespace App\Containers\OrganizationSection\UnitPrice\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\OrganizationSection\UnitPrice\Dto\CreateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Requests\UnitPriceApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Traits\Request\CanPrepareMoney;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @property-read mixed $model_id
 * @property-read mixed $cost_price
 */
class CreateUnitPriceRequest extends UnitPriceApiRequest implements GettableDto
{
    use CanPrepareMoney;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected array $decode = [
        UnitPrice::MODEL_ID,
        UnitPrice::UNIT_ID
    ];

    public function rules(): array
    {
        return [
            UnitPrice::MODEL => $this->getUnitPriceModelValidationRules(),
            UnitPrice::MODEL_ID => $this->getUnitPriceModelIdValidationRules(),
            UnitPrice::UNIT_ID => $this->getOrganizationUnitIdValidationRules(),
            UnitPrice::COST_PRICE => $this->getUnitPriceCostPriceValidationRules(),
            UnitPrice::CLIENT_PRICE => $this->getUnitPriceClientPriceValidationRules()
        ];
    }

    public function getUnitPriceModelValidationRules(): ValidationRules
    {
        return parent::getUnitPriceModelValidationRules()
            ->addRequired();
    }

    public function getUnitPriceModelIdValidationRules(): ValidationRules
    {
        return parent::getUnitPriceModelIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitIdValidationRules()
            ->add(
                $this->getUnitPriceUnitIdExistsValidationRule()
            )
            ->add(
                $this->getUnitPriceUnitIdUniqueValidationRule()
            )
            ->addRequired();
    }

    public function getUnitPriceCostPriceValidationRules(): ValidationRules
    {
        return parent::getUnitPriceCostPriceValidationRules()
            ->addRequired();
    }

    public function getUnitPriceClientPriceValidationRules(): ValidationRules
    {
        return parent::getUnitPriceClientPriceValidationRules()
            ->addRequired();
    }

    public function getUnitPriceUnitIdExistsValidationRule(): Exists
    {
        return $this->getModelType()->existsUnitIdValidationRule();
    }

    public function getUnitPriceUnitIdUniqueValidationRule(): Unique
    {
        return $this->getModelType()
            ->uniqueUnitIdValidationRule(
                $this->model_id
            );
    }

    public function getOrganizationUnitIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationUnitIdExistsValidationRule($column)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->user()->organization_id);
    }

    /**
     * @return CreateUnitPriceDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateUnitPriceDto
    {
        return $this->newDto(
            $this->getDtoData()
        );
    }

    /**
     * @param array $data
     * @return CreateUnitPriceDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateUnitPriceDto
    {
        return new CreateUnitPriceDto($data);
    }

    public function messages(): array
    {
        $unitIdUniqueMessage = $this
            ->getModelType()
            ->getUniqueUnitIdValidationRuleValidationMessage();

        return parent::messages() +
            [
                UnitPrice::UNIT_ID . '.unique' => $unitIdUniqueMessage
            ];
    }

    protected function getDtoData(): array
    {
        $data = $this->validated();
        $data[UnitPrice::MODEL] = $this->getModelType()->getModelAccessor();

        return $data;
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationIsInfinityBalance();
        $this->prepareForValidationOrganizationClientPrice();
    }

    protected function prepareForValidationIsInfinityBalance(): void
    {
        $isInfinityBalance = (bool)$this->get(UnitPrice::IS_INFINITY_BALANCE);
        if ($isInfinityBalance) {
            $this->merge([
                UnitPrice::BALANCE => ZERO
            ]);
        }
    }

    protected function prepareForValidationOrganizationClientPrice(): void
    {
        $this
            ->prepareMoney(UnitPrice::COST_PRICE)
            ->prepareMoney(UnitPrice::CLIENT_PRICE);
    }
}
