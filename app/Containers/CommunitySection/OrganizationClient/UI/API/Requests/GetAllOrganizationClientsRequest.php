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

namespace App\Containers\CommunitySection\OrganizationClient\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationClient\Requests\OrganizationClientApiRequest;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Transformers\OrganizationClientToListTransformer;
use App\Ship\Contracts\IsListableRequest;
use App\Ship\Traits\Request\ListableTransformerRequest;

class GetAllOrganizationClientsRequest extends OrganizationClientApiRequest implements IsListableRequest
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

    public function getToListTransformer(): OrganizationClientToListTransformer
    {
        return new OrganizationClientToListTransformer();
    }
}
