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

use App\Containers\AppSection\User\Models\User;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Contracts\Namebled;
use App\Ship\Parents\Models\Model;
use App\Ship\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

abstract class Type implements Namebled
{
    abstract public function setPriorityModelAttributes(Collection $attributes, array &$priorityAttributes): void;
    abstract public function getModelAccessor(): string;
    abstract public function getModelKey(): string;

    abstract public function existsModelId(int|string $id): bool;

    abstract public function findModel(int|string $id): ?Model;

    public function existsUnitIdValidationRule(): Exists
    {
        return Rule::exists(OrganizationUnit::TABLE, ID);
    }

    public function uniqueUnitIdValidationRule(int|string $modelId, int|string|null $ignoreUnitId = null): Unique
    {
        $rule = Rule::unique(UnitPriceModel::TABLE, UnitPrice::UNIT_ID)
            ->where(UnitPrice::MODEL, $this->getModelAccessor())
            ->where(UnitPrice::MODEL_ID, $modelId);

        if ($ignoreUnitId) {
            $rule->ignore($ignoreUnitId, UnitPrice::UNIT_ID);
        }

        return $rule;
    }

    public function getUniqueUnitIdValidationRuleValidationMessage(): string
    {
        return Container::trans('container.' . $this->getModelKey() . '.unique');
    }

    public function noExistsModelIdValidationMessage(): string
    {
        return Container::trans('container.' . $this->getModelKey() . '.no_exists_model_id');
    }

    public function getModel(): Model
    {
        return app($this->getModelAccessor());
    }

    protected function user(): User
    {
        return Auth::user();
    }

    protected function withPrefix(string $value): string
    {
        return $this->prefix() . $value;
    }

    protected function prefix(): string
    {
        return $this->getModelKey() . '_';
    }
}
