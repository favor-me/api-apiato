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

namespace App\Containers\CommunitySection\OrganizationClient\Data\Factories;

use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|OrganizationClientModel create($attributes = [], ?Model $parent = null)
 * @method Collection|OrganizationClientModel make($attributes = [], ?Model $parent = null)
 */
final class OrganizationClientFactory extends Factory
{
    use HasTrashedState;

    protected $model = OrganizationClientModel::class;

    public function definition(): array
    {
        return [
            OrganizationClient::NAME => $this->faker->title,
            OrganizationClient::NOTE => $this->faker->text(50),
            OrganizationClient::ORGANIZATION_ID => OrganizationModel::factory(),
            OrganizationClient::PATRONYMIC => $this->faker->text(50),
            OrganizationClient::PHONE_NUMBER => $this->faker->e164PhoneNumber,
            OrganizationClient::SURNAME => $this->faker->text(50)
        ];
    }
}
