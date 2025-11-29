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

namespace App\Containers\OrganizationSection\UnitPrice\Map;

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;

class ContractType extends Type
{
    public function getModelAccessor(): string
    {
        return ContractModel::class;
    }

    public function getModelKey(): string
    {
        return 'contract';
    }

    public function getName(): string
    {
        return trans_choice(Container::transFullKey('container.items'), 1);
    }

    public function existsModelId(int|string $id): bool
    {
        return DB::table($this->getModel()->getTable())
            ->where(ID, $id)
            ->where(Contract::ORGANIZATION_ID, $this->user()->organization_id)
            ->exists();
    }

    public function existsUnitIdValidationRule(): Exists
    {
        return parent::existsUnitIdValidationRule()
            ->where(Contract::ORGANIZATION_ID, $this->user()->organization_id);
    }
}
