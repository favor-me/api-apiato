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

namespace App\Containers\CommunitySection\OrganizationBranch\UI\API\Requests;

use Apiato\Core\Abstracts\Models\UserModel as User;
use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationBranch\Requests\OrganizationBranchApiRequest;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\OrganizationBranchToListTransformer;
use App\Ship\Contracts\IsListableRequest;
use App\Ship\Traits\Request\ListableTransformerRequest;

class GetAllOrganizationBranchesRequest extends OrganizationBranchApiRequest implements IsListableRequest
{
    use ListableTransformerRequest;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function hasAccess(?User $user = null): bool
    {
        if ($this->isToList()) {
            $this->clearAccess();
        }

        return parent::hasAccess($user);
    }

    public function getToListTransformer(): OrganizationBranchToListTransformer
    {
        return new OrganizationBranchToListTransformer();
    }
}
