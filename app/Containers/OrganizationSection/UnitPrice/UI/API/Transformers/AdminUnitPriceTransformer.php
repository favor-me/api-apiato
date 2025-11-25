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

class AdminUnitPriceTransformer extends UnitPriceTransformer
{
    public function transform(UnitPriceModel $unitPrice): array
    {
        return parent::transform($unitPrice) +
            [
                $this->realKey(ID) => $unitPrice->id,
                $this->realKey(UnitPrice::MODEL_ID) => $unitPrice->model_id,
                $this->realKey(UnitPrice::UNIT_ID) => $unitPrice->unit_id
            ];
    }
}
