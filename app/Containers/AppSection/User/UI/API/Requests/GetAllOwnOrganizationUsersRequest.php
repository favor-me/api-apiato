<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Containers\AppSection\User\Traits\IsOrganizationOwner;

class GetAllOwnOrganizationUsersRequest extends UserApiRequest
{
    use IsOrganizationOwner;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function getOrganizationId(): int
    {
        return $this->user()->organization_id;
    }

    public function getAuthUserId(): int
    {
        return $this->user()->id;
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }
}
