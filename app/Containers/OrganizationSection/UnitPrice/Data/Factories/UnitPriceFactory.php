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

namespace App\Containers\OrganizationSection\UnitPrice\Data\Factories;

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|UnitPriceModel create($attributes = [], ?Model $parent = null)
 * @method Collection|UnitPriceModel make($attributes = [], ?Model $parent = null)
 */
final class UnitPriceFactory extends Factory
{
    use HasTrashedState;

    protected $model = UnitPriceModel::class;

    public function definition(): array
    {
        $costPriceVal = 100;
        $priceUpVal = 10;

        $costPrice = app('money')
            ->addCurrency($costPriceVal)
            ->val();

        $clientPrice = app('money')
            ->addCurrency($costPriceVal)
            ->multiply(100 / $priceUpVal)
            ->val();

        $contract = ContractModel::factory()
            ->counterparty()
            ->create();

        return [
            UnitPrice::CLIENT_PRICE => $clientPrice,
            UnitPrice::COST_PRICE => $costPrice,
            UnitPrice::MODEL => ContractModel::class,
            UnitPrice::MODEL_ID => $contract->id,
            UnitPrice::PRICE_UP => $priceUpVal,
            UnitPrice::UNIT_ID => OrganizationUnit::factory()
        ];
    }
}
