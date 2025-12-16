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
use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        $country = new RuCountry();

        return [
            Organization::EMAIL => $this->faker->email,
            Organization::NAME => uniqid($this->faker->title),
            Organization::PHONE_NUMBER => $this->faker->e164PhoneNumber,
            Organization::USER_OWNER_ID => UserModel::factory(),
            Organization::BANK_DATA => [],
            Organization::COUNTRY => $country->getName(),
            PARAMS => []
        ];
    }

    /**
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function ru(): self
    {
        $country = new RuCountry();
        $randomNumber = $this->faker->randomNumber(1);
        return $this->state(fn() => [
            Organization::COUNTRY => $country->getName(),
            Organization::BANK_DATA => [
                'inn' => '123456789' . $randomNumber,
                'kpp' => $randomNumber . '87654321',
                'orgnip' => '12345678' . $randomNumber . '098765',
                'payment_account' => '12345' . $randomNumber . '78909876543212',
                'correspondent_account' => '123456789098765' . $randomNumber . '3212',
                'bank' => Str::upper($this->faker->word()) . ' Bank',
                'bik' => '1234' . $randomNumber . '6434',
                'okpo' => $randomNumber . '6547364'
            ]
        ]);
    }
}
