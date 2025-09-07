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

namespace App\Containers\CommunitySection\OrganizationClient\UI\API\Transformers;

use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;

class AdminOrganizationClientTransformer extends OrganizationClientTransformer
{
    public function transform(OrganizationClientModel $organizationClient): array
    {
        return parent::transform($organizationClient) +
            [
                $this->realKey(ID) => $organizationClient->id,
                $this->realKey(OrganizationClient::ORGANIZATION_ID) => $organizationClient->organization_id
            ];
    }
}
