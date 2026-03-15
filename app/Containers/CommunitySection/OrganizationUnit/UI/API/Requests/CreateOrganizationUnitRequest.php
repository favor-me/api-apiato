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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Dto\CreateOrganizationUnitDto;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Requests\OrganizationUnitApiRequest;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Traits\Request\CanPrepareMoney;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @property-read int $cost_price
 * @property-read int $client_price
 */
class CreateOrganizationUnitRequest extends OrganizationUnitApiRequest implements GettableDto
{
    use CanPrepareMoney;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();

        $this->mergeDecode([
            OrganizationUnit::SYSTEM_UNIT_ID
        ]);
    }

    public function rules(): array
    {
        return [
            OrganizationUnit::NAME => $this->getOrganizationUnitNameValidationRules(),
            OrganizationUnit::TYPE => $this->getOrganizationUnitTypeValidationRules(),
            OrganizationUnit::SKU => $this->getOrganizationUnitSkuValidationRules(),
            OrganizationUnit::ORDERING => $this->getOrganizationUnitOrderingValidationRules(),
            UnitPrice::COST_PRICE => $this->getOrganizationUnitCostPriceValidationRules(),
            UnitPrice::CLIENT_PRICE => $this->getOrganizationUnitClientPriceValidationRules(),
            OrganizationUnit::ORGANIZATION_ID => $this->getOrganizationUnitOrganizationIdValidationRules(),
            OrganizationUnit::SYSTEM_UNIT_ID => $this->getOrganizationUnitSystemUnitIdValidationRules(),
        ];
    }

    public function getOrganizationUnitClientPriceValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitClientPriceValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitSystemUnitIdValidationRules(): ValidationRules
    {
        return $this->getUnitIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitNameValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitNameValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitTypeValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitTypeValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitOrganizationIdValidationRules(): ValidationRules
    {
        return $this->getOrganizationIdValidationRules()
            ->addRequired();
    }

    /**
     * @return CreateOrganizationUnitDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateOrganizationUnitDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateOrganizationUnitDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateOrganizationUnitDto
    {
        return new CreateOrganizationUnitDto($data);
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
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
