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
use App\Containers\OrganizationSection\UnitPrice\Requests\UnitPriceApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputId;

class FindUnitPriceByIdRequest extends UnitPriceApiRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    protected array $decode = [
        ID
    ];

    protected array $urlParameters = [
        ID
    ];

    public function rules(): array
    {
        return [
            ID => $this->getUnitPriceIdValidationRules()
        ];
    }

    public function getUnitPriceIdValidationRules(): ValidationRules
    {
        return parent::getUnitPriceIdValidationRules()
            ->addRequired();
    }
}
