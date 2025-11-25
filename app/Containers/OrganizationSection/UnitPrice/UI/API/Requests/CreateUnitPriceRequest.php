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
use App\Containers\OrganizationSection\UnitPrice\Dto\CreateUnitPriceDto;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Requests\UnitPriceApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateUnitPriceRequest extends UnitPriceApiRequest implements GettableDto
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function rules(): array
    {
        return [
            UnitPrice::MODEL => $this->getUnitPriceModelValidationRules(),
            UnitPrice::MODEL_ID => $this->getUnitPriceModelIdValidationRules(),
            UnitPrice::UNIT_ID => $this->getUnitPriceUnitIdValidationRules(),
            UnitPrice::COST_PRICE => $this->getUnitPriceCostPriceValidationRules(),
            UnitPrice::PRICE_UP => $this->getUnitPricePriceUpValidationRules(),
            UnitPrice::CLIENT_PRICE => $this->getUnitPriceClientPriceValidationRules(),
        ];
    }

    /**
     * @return CreateUnitPriceDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateUnitPriceDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateUnitPriceDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateUnitPriceDto
    {
        return new CreateUnitPriceDto($data);
    }
}
