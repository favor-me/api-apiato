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
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Requests\UnitPriceApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\ListableTransformerRequest;

/**
 * @property-read mixed $model_id
 */
class GetAllUnitPricesRequest extends UnitPriceApiRequest
{
    use ListableTransformerRequest;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();

        $this
            ->mergeDecode(UnitPrice::MODEL_ID)
            ->mergeUrlParameters(UnitPrice::MODEL_ID);
    }

    public function rules(): array
    {
        return [
            UnitPrice::MODEL => $this->getUnitPriceModelValidationRules(),
            UnitPrice::MODEL_ID => $this->getUnitPriceModelIdValidationRules()
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
}
