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

namespace App\Containers\ShiftSection\Shift\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Requests\ShiftApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Validation\Rules\Exists;

class FindShiftByIdRequest extends ShiftApiRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    protected array $urlParameters = [
        ID
    ];

    public function rules(): array
    {
        return [
            ID => $this->getShiftIdValidationRules()
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
        $this->mergeDecode(ID);
    }
}
