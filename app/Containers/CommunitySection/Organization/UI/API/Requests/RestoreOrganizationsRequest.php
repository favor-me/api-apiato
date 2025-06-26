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
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Requests\ApiRestoreRequest;

class RestoreOrganizationsRequest extends ApiRestoreRequest
{
    protected array $access = [
        PERMISSIONS => Permissions::READ_ARCHIVE
    ];

    public function getTableName(): string
    {
        return OrganizationModel::TABLE;
    }
}
