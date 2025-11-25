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

use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
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
        return [
            UnitPrice::CLIENT_PRICE => null,
            UnitPrice::COST_PRICE => null,
            UnitPrice::MODEL => $this->faker->text(50),
            UnitPrice::MODEL_ID => null,
            UnitPrice::PRICE_UP => null,
            UnitPrice::UNIT_ID => null
        ];
    }
}
