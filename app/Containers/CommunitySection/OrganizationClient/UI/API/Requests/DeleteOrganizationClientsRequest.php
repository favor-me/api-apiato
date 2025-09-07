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

use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;

class DeleteOrganizationClientsRequest extends TrashOrganizationClientsRequest
{
    public function getOrganizationClientIdValidationRules(): ValidationRules
    {
        return validation_rules([
            Rule::exists(OrganizationClientModel::TABLE, ID)
                ->where(OrganizationClient::ORGANIZATION_ID, $this->organization_id)
                ->whereNotNull(DELETED_AT)
        ])->addRequired();
    }
}
