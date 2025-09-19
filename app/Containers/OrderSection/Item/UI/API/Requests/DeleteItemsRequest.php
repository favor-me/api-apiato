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

namespace App\Containers\OrderSection\Item\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Requests\ItemApiRequest;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputIds;
use Illuminate\Validation\Rules\Exists;

/**
 * @property-read mixed $order_id
 */
class DeleteItemsRequest extends ItemApiRequest
{
    use HasInputIds;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_WORKER,
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected array $urlParameters = [
        Item::ORDER_ID
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode([
            IDS . '.*',
            Item::ORDER_ID,
            Order::ORGANIZATION_ID
        ]);
    }

    public function rules(): array
    {
        return [
            Item::ORDER_ID => $this->getOrderIdValidationRules(),
            IDS . '.*' => $this->getItemIdValidationRules()
        ];
    }

    public function getOrderIdValidationRules(): ValidationRules
    {
        return parent::getOrderIdValidationRules()
            ->addRequired();
    }

    public function getItemIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getItemIdExistsValidationRule($column)
            ->where(Item::ORDER_ID, $this->order_id);
    }
}
