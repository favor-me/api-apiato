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
use App\Containers\AccountingSection\Contract\Tasks\FindContractByIdTask;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Ship\Exceptions\NotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;

class ContractType extends Type
{
    public function getModelAccessor(): string
    {
        return ContractModel::class;
    }

    /**
     * @param int|string $id
     * @return ContractModel|null
     * @throws NotFoundException
     */
    public function findModel(int|string $id): ?ContractModel
    {
        return app(FindContractByIdTask::class)->run($id);
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

    public function setPriorityModelAttributes(Collection $attributes, array &$priorityAttributes): void
    {
        $contractAttributes = $attributes
            ->where(function ($value, $key) {
                return str_starts_with($key, $this->prefix()) &&
                    !in_array($key, $this->excludePriorityModelAttributes());
            });

        if ($contractAttributes->isNotEmpty()) {
            $priorityAttributes[OrganizationUnit::PRIORITY_FROM] = $this->getModelKey();
        }

        $contractAttributes
            ->each(function ($value, $key) use (&$priorityAttributes) {
                $name = str_replace($this->prefix(), '', $key);
                $priorityAttributes['priority_' . $name] = $value;
            });
    }

    protected function excludePriorityModelAttributes(): array
    {
        return [
            $this->withPrefix(UnitPrice::BALANCE),
            $this->withPrefix(UnitPrice::COST_PRICE),
            $this->withPrefix(UnitPrice::IS_INFINITY_BALANCE)
        ];
    }
}
