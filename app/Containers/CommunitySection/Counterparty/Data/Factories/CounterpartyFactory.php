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

namespace App\Containers\CommunitySection\Counterparty\Data\Factories;

use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\OrganizationSection\OwnershipType\Manager as OwnershipTypeManager;
use App\Containers\OrganizationSection\OwnershipType\OooType;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method Collection|CounterpartyModel create($attributes = [], ?Model $parent = null)
 * @method Collection|CounterpartyModel make($attributes = [], ?Model $parent = null)
 */
final class CounterpartyFactory extends Factory
{
    use HasTrashedState;

    protected $model = CounterpartyModel::class;

    public function definition(): array
    {
        $country = new RuCountry();
        $ownershipType = OwnershipTypeManager::getInstance()->get(OooType::class);

        return [
            Counterparty::LEGAL_ADDRESS => $this->faker->address(),
            Counterparty::MAILING_ADDRESS => $this->faker->address(),
            Counterparty::BANK_DATA => [],
            Counterparty::COUNTRY => $country->getName(),
            Counterparty::EMAIL => $this->faker->email,
            Counterparty::NAME => $this->faker->title,
            Counterparty::OWNERSHIP_TYPE => $ownershipType->getName(),
            Counterparty::ORGANIZATION_ID => Organization::factory(),
            Counterparty::PHONE_NUMBER => $this->faker->e164PhoneNumber
        ];
    }

    public function organization(int $id): self
    {
        return $this->state(fn() => [
            Counterparty::ORGANIZATION_ID => $id
        ]);
    }

    public function rus(): self
    {
        $country = new RuCountry();
        $randomNumber = $this->faker->randomNumber(1);
        return $this->state(fn() => [
            Counterparty::COUNTRY => $country->getName(),
            Counterparty::BANK_DATA => [
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
