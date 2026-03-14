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

namespace App\Containers\OrganizationSection\UnitPrice\UI\API\Transformers;

use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Parents\Transformers\Transformer;

class UnitPriceTransformer extends Transformer
{
    public function transform(UnitPriceModel $unitPrice): array
    {
        return [
            OBJECT => $unitPrice->getResourceKey(),
            ID => $unitPrice->getHashedKey(),
            UnitPrice::MODEL => $unitPrice->model,
            UnitPrice::MODEL_ID => $unitPrice->getHashedKey(UnitPrice::MODEL_ID),
            UnitPrice::UNIT_ID => $unitPrice->getHashedKey(UnitPrice::UNIT_ID),
            UnitPrice::COST_PRICE => $this->money($unitPrice->cost_price),
            UnitPrice::CLIENT_PRICE => $this->money($unitPrice->client_price),
            UnitPrice::BALANCE => $unitPrice->balance,
            UnitPrice::IS_INFINITY_BALANCE => $unitPrice->is_infinity_balance,
        ];
    }
}
