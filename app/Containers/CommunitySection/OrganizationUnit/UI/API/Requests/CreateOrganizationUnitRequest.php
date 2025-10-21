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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Dto\CreateOrganizationUnitDto;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Requests\OrganizationUnitApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Request\CanPrepareMoney;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrganizationUnitRequest extends OrganizationUnitApiRequest implements GettableDto
{
    use CanPrepareMoney;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected ?Money $internalClientPrice = null;

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
            OrganizationUnit::COST_PRICE => $this->getOrganizationUnitCostPriceValidationRules(),
            OrganizationUnit::PRICE_UP => $this->getOrganizationUnitPriceUpValidationRules(),
            OrganizationUnit::CLIENT_PRICE => $this->getOrganizationUnitClientPriceValidationRules(),
            OrganizationUnit::IS_INFINITY_BALANCE => $this->getOrganizationUnitIsInfinityBalanceValidationRules(),
            OrganizationUnit::ORGANIZATION_ID => $this->getOrganizationUnitOrganizationIdValidationRules(),
            OrganizationUnit::SYSTEM_UNIT_ID => $this->getOrganizationUnitSystemUnitIdValidationRules(),
        ];
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

    public function messages(): array
    {
        $messages = parent::messages();

        if ($this->has(OrganizationUnit::COST_PRICE)) {
            $messages[OrganizationUnit::CLIENT_PRICE . '.size'] = Container::trans('validation.client_price.size', [
                'size' => $this->internalClientPrice->currency()->text()
            ]);
        }

        return $messages;
    }

    public function getOrganizationUnitClientPriceValidationRules(): ValidationRules
    {
        $rules = parent::getOrganizationUnitClientPriceValidationRules();

        $priceUp = (float)$this->get(OrganizationUnit::PRICE_UP);
        if ($this->has(OrganizationUnit::COST_PRICE) && $priceUp > 0) {
            $rules->add('size:' . $this->internalClientPrice->val());
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->prepareForValidationIsInfinityBalance();
        $this->prepareForValidationOrganizationClientPrice();
    }

    protected function prepareForValidationIsInfinityBalance(): void
    {
        $isInfinityBalance = (bool)$this->get(OrganizationUnit::IS_INFINITY_BALANCE);
        if ($isInfinityBalance) {
            $this->merge([
                OrganizationUnit::BALANCE => ZERO
            ]);
        }
    }

    protected function prepareForValidationOrganizationClientPrice(): void
    {
        $this
            ->prepareMoney(OrganizationUnit::COST_PRICE)
            ->prepareMoney(OrganizationUnit::CLIENT_PRICE);

        if ($this->has(OrganizationUnit::COST_PRICE)) {
            $costPrice = app('money')
                ->addCurrency(
                    $this->get(OrganizationUnit::COST_PRICE)
                );

            $clientPrice = app('money')->add($costPrice);
            $priceUp = (float)$this->get(OrganizationUnit::PRICE_UP);

            if ($priceUp > ZERO) {
                $clientPrice->add($priceUp . '%');
            }

            $this->internalClientPrice = $clientPrice;
            if (empty($this->get(OrganizationUnit::CLIENT_PRICE))) {
                $this->merge([
                    OrganizationUnit::CLIENT_PRICE => $this->internalClientPrice->val()
                ]);
            }
        }
    }
}
