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

namespace App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers;

use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;

class AdminOrganizationBranchTransformer extends OrganizationBranchTransformer
{
    public function transform(OrganizationBranchModel $organizationBranch): array
    {
        $organizationId = OrganizationBranch::ORGANIZATION_ID;
        $responsibleBy = OrganizationBranch::RESPONSIBLE_BY;

        return parent::transform($organizationBranch) +
            [
                $this->realKey(ID) => $organizationBranch->getHashedKey(ID),
                $this->realKey($organizationId) => $organizationBranch->getHashedKey($organizationId),
                $this->realKey($responsibleBy) => $organizationBranch->getHashedKey($responsibleBy)
            ];
    }
}
