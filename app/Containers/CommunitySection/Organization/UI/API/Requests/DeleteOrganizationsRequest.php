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

use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;

class DeleteOrganizationsRequest extends TrashOrganizationsRequest
{
    protected array $access = [
        PERMISSIONS => Permissions::DELETE
    ];

    public function getOrganizationIdValidationRules(): ValidationRules
    {
        return validation_rules([
            Rule::exists(OrganizationModel::TABLE, ID)
                ->whereNotNull(DELETED_AT)
        ])->addRequired();
    }
}
