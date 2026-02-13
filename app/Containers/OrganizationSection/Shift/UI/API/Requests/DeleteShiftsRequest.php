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

namespace App\Containers\OrganizationSection\Shift\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\OrganizationSection\Shift\Requests\ShiftApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputIds;
use Illuminate\Validation\Rules\Exists;

class DeleteShiftsRequest extends ShiftApiRequest
{
    use HasInputIds;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function rules(): array
    {
        return [
            IDS . '.*' => $this->getShiftIdValidationRules()
        ];
    }

    public function getShiftIdValidationRules(): ValidationRules
    {
        return parent::getShiftIdValidationRules()
            ->addRequired();
    }

    public function getShiftIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getShiftIdExistsValidationRule($column)
            ->where(Shift::ORGANIZATION_ID, $this->organization_id);
    }

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode([IDS . '.*']);
    }
}
