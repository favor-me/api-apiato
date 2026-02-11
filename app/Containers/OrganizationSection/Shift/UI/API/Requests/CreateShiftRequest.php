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
use App\Containers\OrganizationSection\Shift\Dto\CreateShiftDto;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\OrganizationSection\Shift\Requests\ShiftApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateShiftRequest extends ShiftApiRequest implements GettableDto
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function rules(): array
    {
        return [
            Shift::ORGANIZATION_ID => $this->getShiftOrganizationIdValidationRules(),
            Shift::START_AT => $this->getShiftStartAtValidationRules(),
            Shift::FINISH_AT => $this->getShiftFinishAtValidationRules(),
            'created_by' => $this->getShiftCreatedByValidationRules(),
        ];
    }

    /**
     * @return CreateShiftDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateShiftDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateShiftDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateShiftDto
    {
        return new CreateShiftDto($data);
    }
}
