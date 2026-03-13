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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;

final class AdminOrganizationUnitTransformer extends OrganizationUnitTransformer
{
    public function transform(OrganizationUnitModel $organizationUnit): array
    {
        return parent::transform($organizationUnit) +
            [
                $this->realKey(ID) => $organizationUnit->id,
                $this->realKey(OrganizationUnit::ORGANIZATION_ID) => $organizationUnit->organization_id,
                $this->realKey(OrganizationUnit::SYSTEM_UNIT_ID) => $organizationUnit->system_unit_id
            ];
    }
}
