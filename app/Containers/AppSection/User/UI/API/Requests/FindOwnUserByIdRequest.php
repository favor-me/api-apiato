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
use App\Ship\Collections\ValidationRules;

class FindOwnUserByIdRequest extends FindUserByIdRequest
{
    protected array $access = [
        PERMISSIONS => '',
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess'
        ]);
    }

    public function getUserIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getUserExistsInOrganizationValidationRule(
                $this->user()->organization_id
            )
        ])->addRequired();
    }
}
