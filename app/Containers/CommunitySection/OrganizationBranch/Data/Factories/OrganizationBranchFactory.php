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

namespace App\Containers\CommunitySection\OrganizationBranch\Data\Factories;

use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|OrganizationBranchModel create($attributes = [], ?Model $parent = null)
 * @method Collection|OrganizationBranchModel make($attributes = [], ?Model $parent = null)
 */
final class OrganizationBranchFactory extends Factory
{
    use HasTrashedState;

    protected $model = OrganizationBranchModel::class;

    public function definition(): array
    {
        $organization = OrganizationModel::factory()->create();

        return [
            OrganizationBranch::LATITUDE => null,
            OrganizationBranch::LOCATION => $this->faker->text(50),
            OrganizationBranch::LONGITUDE => null,
            OrganizationBranch::NAME => $this->faker->title,
            OrganizationBranch::ORGANIZATION_ID => $organization->id,
            OrganizationBranch::PHONE_NUMBER => $this->faker->e164PhoneNumber,
            OrganizationBranch::RESPONSIBLE_BY => $organization->user_owner_id
        ];
    }
}
