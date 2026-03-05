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

namespace App\Containers\ShiftSection\Item\Requests;

use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Traits\OrderValidationRules;
use App\Containers\ShiftSection\Item\Traits\ItemValidationRules;
use App\Containers\ShiftSection\Item\UI\API\Transformers\ItemTransformerManager;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Traits\ShiftValidationRules;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;
use Illuminate\Validation\Rules\Exists;

abstract class ItemApiRequest extends ApiRequest implements GettableTransformer
{
    use ItemValidationRules;

    use OrderValidationRules {
        getOrderIdExistsValidationRule as parentGetOrderIdExistsValidationRule;
    }

    use ShiftValidationRules {
        getShiftIdExistsValidationRule as parentGetShiftIdExistsValidationRule;
    }

    public function getTransformer(): Transformer
    {
        return (new ItemTransformerManager())->getDefaultOrAdmin();
    }

    public function getOrderIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return $this->parentGetOrderIdExistsValidationRule($column)
            ->where(Order::ORGANIZATION_ID, $this->user()->organization_id);
    }

    public function getShiftIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return $this->parentGetShiftIdExistsValidationRule($column)
            ->where(Shift::ORGANIZATION_ID, $this->user()->organization_id);
    }
}
