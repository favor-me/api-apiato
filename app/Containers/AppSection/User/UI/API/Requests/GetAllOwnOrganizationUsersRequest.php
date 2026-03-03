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

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Containers\AppSection\User\Traits\IsOrganizationOwner;
use App\Containers\AppSection\User\UI\API\Transformers\UserToListTransformer;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformerManager;
use App\Ship\Contracts\IsListableRequest;
use App\Ship\Traits\Request\ListableTransformerRequest;

class GetAllOwnOrganizationUsersRequest extends UserApiRequest implements IsListableRequest
{
    use IsOrganizationOwner;
    use ListableTransformerRequest;

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

    public function getToListTransformer(): UserToListTransformer
    {
        return (new UserTransformerManager())->getToList();
    }
}
