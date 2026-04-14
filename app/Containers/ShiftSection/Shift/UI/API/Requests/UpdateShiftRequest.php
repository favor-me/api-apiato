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
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\ShiftSection\Shift\Dto\UpdateShiftDto;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use App\Ship\Validation\Rule;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Exists;

/**
 * @method UpdateShiftDto getDto()
 */
class UpdateShiftRequest extends CreateShiftRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected array $urlParameters = [
        ID
    ];

    protected function afterInitialize(): void
    {
        $this->mergeDecode(ID);
    }

    public function rules(): array
    {
        $rules = array_merge(parent::rules(), [
            ID => $this->getShiftIdValidationRules(),
            Shift::ORGANIZATION_BRANCH_ID => $this->getOrganizationBranchIdValidationRules()
        ]);

        if ($this->user()->is_organization_owner) {
            $rules[CONFIRMED] = Rule::boolean();
            $rules[Shift::PAYMENT] = Rule::boolean();
        }

        return $rules;
    }

    public function getOrganizationBranchIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationBranchIdExistsValidationRule($column)
            ->where(OrganizationBranch::ORGANIZATION_ID, $this->organization_id);
    }

    public function getShiftIdValidationRules(): ValidationRules
    {
        return parent::getShiftIdValidationRules()
            ->addRequired();
    }

    public function newDto(array $data = []): UpdateShiftDto
    {
        return new UpdateShiftDto($data);
    }

    protected function commonDtoData(): array
    {
        $data = parent::commonDtoData();

        if ($this->has(Shift::ORGANIZATION_BRANCH_ID)) {
            unset($data[Shift::ORGANIZATION_BRANCH_ID]);
        }

        if ($this->user()->is_organization_owner) {
            $this->organizationOwnerDtoData($data);
        }

        return $data;
    }

    protected function organizationOwnerDtoData(&$data): void
    {
        if ($this->get(CONFIRMED)) {
            $data[Shift::CONFIRMED_BY] = $this->user()->id;
        }
    }

    public function getShiftStartAtValidationRules(): ValidationRules
    {
        return parent::getShiftStartAtValidationRules()
            ->removeRequired();
    }

    public function getShiftFinishAtValidationRules(): ValidationRules
    {
        return parent::getShiftFinishAtValidationRules()
            ->removeRequired();
    }

    protected function checkNowShift(): void
    {
        // No check.
    }

    /**
     * @return bool
     * @throws ValidationFailedException
     * @throws AuthorizationException
     */
    protected function passesAuthorization(): bool
    {
        $result = parent::passesAuthorization();
        if ($result === true) {
            $this->throwIfEmptyInput();
        }

        return $result;
    }
}
