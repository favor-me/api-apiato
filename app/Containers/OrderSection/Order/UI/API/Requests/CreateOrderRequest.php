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

namespace App\Containers\OrderSection\Order\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Dto\CreateOrderDto;
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Requests\OrderApiRequest;
use App\Containers\OrderSection\PaymentType\ContractType;
use App\Containers\OrderSection\PaymentType\Manager;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Request\CanPrepareMoney;
use Illuminate\Validation\Rules\Exists;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @property-read mixed $items
 */
class CreateOrderRequest extends OrderApiRequest implements GettableDto
{
    use CanPrepareMoney;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_WORKER,
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected ?Money $total = null;

    protected function afterInitialize(): void
    {
        parent::afterInitialize();

        $this->mergeDecode([
            Order::CLIENT_ID,
            Order::CONTRACT_ID,
            Order::ITEMS . '.*.' . Item::UNIT_ID
        ]);
    }

    public function rules(): array
    {
        return [
            Order::ORGANIZATION_ID => $this->getOrganizationIdValidationRules(),
            Order::PAYMENT_TYPE => $this->getOrderPaymentTypeValidationRules(),
            Order::TOTAL => $this->getOrderTotalValidationRules(),
            Order::COMMENT => $this->getOrderCommentValidationRules(),
            Order::CLIENT_ID => $this->getOrganizationClientIdValidationRules(),
            Order::CONTRACT_ID => $this->getContractIdValidationRules(),
            Order::ITEMS => $this->getOrderItemsValidationRules(),
            Order::ITEMS . '.*.' . Item::AMOUNT => $this->getItemAmountValidationRules(),
            Order::ITEMS . '.*.' . Item::NAME => $this->getItemNameValidationRules(),
            Order::ITEMS . '.*.' . Item::CLIENT_PRICE => $this->getItemClientPriceValidationRules(),
            Order::ITEMS . '.*.' . Item::COST_PRICE => $this->getItemCostPriceValidationRules(),
            Order::ITEMS . '.*.' . Item::SKU => $this->getOrganizationUnitSkuValidationRules(),
            Order::ITEMS . '.*.' . Item::TYPE => $this->getItemTypeValidationRules(),
            Order::ITEMS . '.*.' . Item::UNIT_ID => $this->getOrganizationUnitIdValidationRules(),
        ];
    }

    public function getOrderTotalValidationRules(): ValidationRules
    {
        $rules = parent::getOrderTotalValidationRules()
            ->addRequired();

        if (!is_null($this->total)) {
            $rules->add('size:' . $this->total->val());
        }

        return $rules;
    }

    public function getOrganizationUnitSkuValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getOrganizationUnitSkuExistsValidationRule()
        ]);
    }

    public function getContractIdValidationRules(): ValidationRules
    {
        $rules = parent::getContractIdValidationRules();

        if ($this->isContractPaymentType()) {
            $rules->addRequired();
        }

        return $rules;
    }

    public function getOrganizationUnitSkuExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationUnitSkuExistsValidationRule($column)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->organization_id);
    }

    public function getContractIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getContractIdExistsValidationRule($column)
            ->where(Order::ORGANIZATION_ID, $this->organization_id);
    }

    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationUnitIdExistsValidationRule($column)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->organization_id);
    }

    public function getItemNameValidationRules(): ValidationRules
    {
        return parent::getItemNameValidationRules()
            ->addRequired();
    }

    public function getItemCostPriceValidationRules(): ValidationRules
    {
        return parent::getItemCostPriceValidationRules()
            ->addRequired();
    }

    public function getItemClientPriceValidationRules(): ValidationRules
    {
        return parent::getItemClientPriceValidationRules()
            ->addRequired();
    }

    public function getItemAmountValidationRules(): ValidationRules
    {
        return parent::getItemAmountValidationRules()
            ->addRequired();
    }

    public function getOrderItemsValidationRules(): ValidationRules
    {
        return validation_rules([
            'required',
            'array'
        ]);
    }

    public function getOrganizationIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationIdValidationRules()
            ->addRequired();
    }

    public function getOrderPaymentTypeValidationRules(): ValidationRules
    {
        return parent::getOrderPaymentTypeValidationRules()
            ->addRequired();
    }

    /**
     * @return CreateOrderDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateOrderDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateOrderDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateOrderDto
    {
        return new CreateOrderDto($data);
    }

    public function messages(): array
    {
        $messages = parent::messages();

        if (!is_null($this->total)) {
            $messages[Order::TOTAL . '.size'] = Container::trans('validation.total.size', [
                'size' => $this->total->currency()->text()
            ]);
        }

        return $messages;
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->prepareItemsPricesForValidation();
        $this->prepareClientIdForValidation();
        $this->prepareTotalForValidation();
    }

    protected function prepareClientIdForValidation(): void
    {
        if ($this->isContractPaymentType()) {
            $this->merge([
                Order::CLIENT_ID => null
            ]);
        } else {
            $this->merge([
                Order::CONTRACT_ID => null
            ]);
        }
    }

    protected function prepareItemsPricesForValidation(): void
    {
        $total = app('money');

        $items = collect((array)$this->get(Order::ITEMS))
            ->map(function ($item) use (&$total) {
                if (array_key_exists(Item::COST_PRICE, (array)$item)) {
                    $item[Item::COST_PRICE] = app('money')
                        ->addCurrency($item[Item::COST_PRICE])
                        ->val();
                }

                if (array_key_exists(Item::CLIENT_PRICE, (array)$item)) {
                    $item[Item::CLIENT_PRICE] = app('money')
                        ->addCurrency($item[Item::CLIENT_PRICE])
                        ->val();

                    if (array_key_exists(Item::AMOUNT, $item)) {
                        $clientItemTotalPrice = (new ItemModel([
                            Item::CLIENT_PRICE => $item[Item::CLIENT_PRICE],
                            Item::AMOUNT => $item[Item::AMOUNT]
                        ]))->getTotalClientPrice();

                        $total->add($clientItemTotalPrice);
                    }
                }

                return $item;
            });

        $this->total = $total;

        if ($items->isNotEmpty()) {
            $this->merge([
                Order::ITEMS => $items->toArray()
            ]);
        }
    }

    protected function prepareTotalForValidation(): void
    {
        $this->prepareMoney(Order::TOTAL);
    }

    protected function isContractPaymentType(): bool
    {
        $contractPaymentType = Manager::getInstance()
            ->get(ContractType::class);

        return $this->get(Order::PAYMENT_TYPE) === $contractPaymentType->getName();
    }
}
