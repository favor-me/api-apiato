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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Requests\OrganizationUnitApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Validation\Rules\Exists;

class PlusOrganizationUnitBalanceRequest extends OrganizationUnitApiRequest
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
        parent::afterInitialize();
        $this->mergeDecode(ID);
    }

    public function getBalance(): float
    {
        return (float)$this->get(OrganizationUnit::BALANCE);
    }

    public function isInfinityBalance(): bool
    {
        return (bool)$this->get(OrganizationUnit::IS_INFINITY_BALANCE);
    }

    public function rules(): array
    {
        $rules = [
            ID => $this->getOrganizationUnitIdValidationRules(),
            OrganizationUnit::BALANCE => $this->getOrganizationUnitBalanceValidationRules()
        ];

        if ($this->get(OrganizationUnit::IS_INFINITY_BALANCE)) {
            unset($rules[OrganizationUnit::BALANCE]);
            $rules[OrganizationUnit::IS_INFINITY_BALANCE] = $this
                ->getOrganizationUnitIsInfinityBalanceValidationRules();
        }

        return $rules;
    }
    public function getOrganizationUnitBalanceValidationRules(): ValidationRules
    {
        return validation_rules([
            'required',
            'numeric',
            'gt:' . ZERO
        ]);
    }

    public function getOrganizationUnitIsInfinityBalanceValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitIsInfinityBalanceValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationUnitIdExistsValidationRule($column)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->organization_id);
    }
}
