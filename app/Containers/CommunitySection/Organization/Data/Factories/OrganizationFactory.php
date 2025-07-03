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

namespace App\Containers\CommunitySection\Organization\Data\Factories;

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|OrganizationModel create($attributes = [], ?Model $parent = null)
 * @method Collection|OrganizationModel make($attributes = [], ?Model $parent = null)
 */
final class OrganizationFactory extends Factory
{
    use HasTrashedState;

    protected $model = OrganizationModel::class;

    public function definition(): array
    {
        return [
            Organization::EMAIL => $this->faker->email,
            Organization::INN => $this->faker->numberBetween(),
            Organization::NAME => uniqid($this->faker->title),
            Organization::PHONE_NUMBER => $this->faker->e164PhoneNumber,
            Organization::USER_OWNER_ID => UserModel::factory(),
            PARAMS => []
        ];
    }
}
