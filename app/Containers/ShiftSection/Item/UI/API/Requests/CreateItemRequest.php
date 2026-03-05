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

namespace App\Containers\ShiftSection\Item\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\ShiftSection\Item\Dto\CreateItemDto;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Requests\ItemApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Traits\Request\CanPrepareMoney;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateItemRequest extends ItemApiRequest implements GettableDto
{
    use CanPrepareMoney;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected array $decode = [
        Item::SHIFT_ID,
        Item::ORDER_ID
    ];

    public function rules(): array
    {
        return [
            Item::SHIFT_ID => $this->getShiftIdValidationRules(),
            Item::ORDER_ID => $this->getOrderIdValidationRules(),
            Item::TYPE => $this->getItemTypeValidationRules(),
            Item::VALUE => $this->getItemValueValidationRules(),
            Item::DESCRIPTION => $this->getItemDescriptionValidationRules()
        ];
    }

    public function getItemTypeValidationRules(): ValidationRules
    {
        return parent::getItemTypeValidationRules()
            ->addRequired();
    }

    public function getOrderIdValidationRules(): ValidationRules
    {
        return parent::getOrderIdValidationRules()
            ->add('nullable');
    }

    public function getShiftIdValidationRules(): ValidationRules
    {
        return parent::getShiftIdValidationRules()
            ->addRequired();
    }

    /**
     * @return CreateItemDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateItemDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateItemDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateItemDto
    {
        return new CreateItemDto($data);
    }

    protected function prepareForValidation(): void
    {
        $this->prepareMoneyValueForValidation();
    }

    protected function prepareMoneyValueForValidation(): void
    {
        $this->prepareMoney(Item::VALUE);
    }
}
