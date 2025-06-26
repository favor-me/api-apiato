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

namespace App\Containers\CommunitySection\Organization\UI\API\Requests;

use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use App\Containers\CommunitySection\Organization\Requests\OrganizationApiRequest;
use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationToListTransformer;
use App\Ship\Contracts\IsListableRequest;
use App\Ship\Traits\Request\ListableTransformerRequest;

class GetAllOrganizationsRequest extends OrganizationApiRequest implements IsListableRequest
{
    use ListableTransformerRequest;

    protected array $access = [
        PERMISSIONS => [
            Permissions::READ,
            Permissions::READ_ARCHIVE
        ]
    ];

    public function isOnlyTrashed(): bool
    {
        if (!$this->user()->hasPermissionTo(Permissions::READ_ARCHIVE)) {
            return false;
        }

        return parent::isOnlyTrashed();
    }

    public function getToListTransformer(): OrganizationToListTransformer
    {
        return new OrganizationToListTransformer();
    }
}
