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

namespace App\Containers\OrganizationSection\UnitPrice\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

/**
 * @property-read mixed $unit_ids
 */
class DeleteUnitPricesRequest extends GetAllUnitPricesRequest
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(UnitPrice::UNIT_IDS . '.*');
    }

    public function rules(): array
    {
        return parent::rules() +
            [
                UnitPrice::UNIT_IDS => $this->getUnitPriceUnitIdsValidationRules(),
                UnitPrice::UNIT_IDS . '.*' => $this->getOrganizationUnitIdValidationRules()
            ];
    }

    public function getUnitPriceUnitIdsValidationRules(): ValidationRules
    {
        return validation_rules([
            'array'
        ])->addRequired();
    }

    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitIdValidationRules()
            ->add(
                $this->getUnitPriceUnitIdExitsValidationRule()
            )
            ->addRequired();
    }

    public function getOrganizationUnitIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationUnitIdExistsValidationRule($column)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->user()->organization_id);
    }

    public function getUnitPriceUnitIdExitsValidationRule(): Exists
    {
        return Rule::exists(UnitPriceModel::TABLE, UnitPrice::UNIT_ID)
            ->where(UnitPrice::MODEL, $this->getModelType()->getModelAccessor())
            ->where(UnitPrice::MODEL_ID, $this->model_id);
    }
}
