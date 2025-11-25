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
use App\Containers\OrganizationSection\UnitPrice\UI\API\Transformers\UnitPriceToListTransformer;
use App\Ship\Contracts\IsListableRequest;
use App\Ship\Traits\Request\ListableTransformerRequest;

class GetAllUnitPricesRequest extends UnitPriceApiRequest implements IsListableRequest
{
    use ListableTransformerRequest;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function isOnlyTrashed(): bool
    {
        if (!$this->user()->hasRole(RoleModel::ORGANIZATION_OWNER)) {
            return false;
        }

        return parent::isOnlyTrashed();
    }

    public function getToListTransformer(): UnitPriceToListTransformer
    {
        return new UnitPriceToListTransformer();
    }
}
