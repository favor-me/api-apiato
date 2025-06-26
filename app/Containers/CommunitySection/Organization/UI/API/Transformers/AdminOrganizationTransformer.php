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

namespace App\Containers\CommunitySection\Organization\UI\API\Transformers;

use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;

class AdminOrganizationTransformer extends OrganizationTransformer
{
    public function transform(OrganizationModel $organization): array
    {
        return parent::transform($organization) +
            [
                $this->realKey(ID) => $organization->getHashedKey(ID),
                $this->realKey(Organization::USER_OWNER_ID) => $organization->getHashedKey(Organization::USER_OWNER_ID)
            ];
    }
}
