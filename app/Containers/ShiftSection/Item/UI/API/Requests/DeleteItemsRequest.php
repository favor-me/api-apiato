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

namespace App\Containers\ShiftSection\Item\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\ShiftSection\Item\Requests\ItemApiRequest;
use App\Containers\ShiftSection\Item\Validation\Rules\IsOrganizationShiftItemRule;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputIds;

class DeleteItemsRequest extends ItemApiRequest
{
    use HasInputIds;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected array $decode = [
        IDS . '.*'
    ];

    public function rules(): array
    {
        return [
            IDS . '.*' => $this->getItemIdValidationRules()
        ];
    }

    public function getItemIdValidationRules(): ValidationRules
    {
        return validation_rules()
            ->add(
                new IsOrganizationShiftItemRule($this->user()->organization_id)
            )
            ->addRequired();
    }
}
