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

namespace App\Containers\CommunitySection\OrganizationUnit\Data\Criterias;

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Map\Type;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

class JoinUnitPriceCriteria extends Criteria
{
    public function __construct(
        protected readonly array $priceFrom
    ) {
    }

    /**
     * @param Builder $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        if ($this->hasPriceFrom()) {
            foreach ($this->priceFrom as $priceFrom) {
                $model = $this->joinPrice($model, $priceFrom);
            }
        }

        return $model;
    }

    protected function joinPrice($model, array $priceFrom): Builder
    {
        $priceModel = $priceFrom[UnitPrice::MODEL];
        $priceModelId = $priceFrom[UnitPrice::MODEL_ID];

        $priceType = $this->getPriceModelType($priceModel);

        $unitTable = OrganizationUnitModel::TABLE;
        $unitPriceTable = UnitPriceModel::TABLE;
        $unitPriceAsTable = $priceModel . '_' . $unitPriceTable;

        return $model
            ->leftJoin(
                $unitPriceTable . ' as  ' . $unitPriceAsTable,
                $unitTable . '.' . ID,
                '=',
                $unitPriceAsTable . '.' . UnitPrice::UNIT_ID
            )
            ->select([
                $unitTable . '.*',
                $this->priceAsTableSelect($unitPriceAsTable, UnitPrice::COST_PRICE, $priceModel),
                $this->priceAsTableSelect($unitPriceAsTable, UnitPrice::PRICE_UP, $priceModel),
                $this->priceAsTableSelect($unitPriceAsTable, UnitPrice::CLIENT_PRICE, $priceModel),
                $this->priceAsTableSelect($unitPriceAsTable, UnitPrice::BALANCE, $priceModel),
                $this->priceAsTableSelect($unitPriceAsTable, UnitPrice::IS_INFINITY_BALANCE, $priceModel)
            ])
            ->where($unitPriceAsTable . '.' . UnitPrice::MODEL, $priceType->getModelAccessor())
            ->where($unitPriceAsTable . '.' . UnitPrice::MODEL_ID, $priceModelId);
    }

    protected function priceAsTableSelect(string $table, string $field, string $prefix): string
    {
        return $table . '.' . $field . ' as ' . $prefix . '_' . $field;
    }

    protected function getPriceModelType(string $type): Type
    {
        return Manager::getInstance()->get($type);
    }

    protected function hasPriceFrom(): bool
    {
        return count($this->priceFrom) > ZERO;
    }
}
