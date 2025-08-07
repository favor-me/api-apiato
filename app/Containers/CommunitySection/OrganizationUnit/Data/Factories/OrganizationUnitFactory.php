<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Data\Factories;

use App\Containers\CommunitySection\OrganizationUnitType\Manager;
use App\Containers\CommunitySection\OrganizationUnitType\ProductType;
use App\Containers\Vendor\Unit\Models\Unit as UnitModel;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|OrganizationUnitModel create($attributes = [], ?Model $parent = null)
 * @method Collection|OrganizationUnitModel make($attributes = [], ?Model $parent = null)
 */
final class OrganizationUnitFactory extends Factory
{
    use HasTrashedState;

    protected $model = OrganizationUnitModel::class;

    public function definition(): array
    {
        return [
            OrganizationUnit::BALANCE => null,
            OrganizationUnit::NAME => $this->faker->title,
            OrganizationUnit::ORDERING => ZERO,
            OrganizationUnit::ORGANIZATION_ID => OrganizationModel::factory(),
            OrganizationUnit::CLIENT_PRICE => null,
            OrganizationUnit::PRICE_UP => null,
            OrganizationUnit::COST_PRICE => null,
            OrganizationUnit::SKU => uniqid('sku-'),
            OrganizationUnit::SYSTEM_UNIT_ID => UnitModel::factory(),
            OrganizationUnit::TYPE => Manager::getInstance()->get(ProductType::class),
            PARAMS => []
        ];
    }
}
