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
use App\Containers\OrderSection\Order\Dto\CreateOrderDto;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Requests\OrderApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Traits\Request\CanPrepareMoney;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrderRequest extends OrderApiRequest implements GettableDto
{
    use CanPrepareMoney;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_WORKER,
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(Order::CLIENT_ID);
    }

    public function rules(): array
    {
        return [
            Order::ORGANIZATION_ID => $this->getOrganizationIdValidationRules(),
            Order::PAYMENT_TYPE => $this->getOrderPaymentTypeValidationRules(),
            Order::TOTAL => $this->getOrderTotalValidationRules(),
            Order::COMMENT => $this->getOrderCommentValidationRules(),
            Order::CLIENT_ID => $this->getOrganizationClientIdValidationRules(),
        ];
    }

    public function getOrganizationClientIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationClientIdValidationRules()
            ->addRequired();
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

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->prepareForValidationTotal();
    }

    protected function prepareForValidationTotal(): void
    {
        $this->prepareMoney(Order::TOTAL);
    }
}
