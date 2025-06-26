<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\User\Data\Factories;

use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\User\Models\User;
use App\Containers\LocationSection\City\Models\City;
use App\Containers\LocationSection\Country\Models\Country;
use App\Containers\LocationSection\Region\Models\Region;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @method User|Collection create($attributes = [], ?Model $parent = null)
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function admin(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_admin' => true
            ];
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function city(): UserFactory
    {
        return $this->state(function (array $attributes) {
            $country = Country::factory()->create();

            $region = Region::factory()->create([
                'country_id' => $country->id
            ]);

            $city = City::factory()->create([
                'region_id' => $region->id
            ]);

            return [
                'country_id' => $country->id,
                'region_id' => $region->id,
                'city_id' => $city->id
            ];
        });
    }

    public function contacts(int $count = 1): UserFactory
    {
        return $this->has(Client::factory()->count($count), 'contacts');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function country(): UserFactory
    {
        return $this->state(function (array $attributes) {
            $country = Country::factory()->create();
            return [
                'country_id' => $country->id
            ];
        });
    }

    public function definition(): array
    {
        static $password;

        $name = uniqid('User name ');

        return [
            'name' => $name,
            'login' => Str::slug($name),
            'patronymic' => $this->faker->word,
            'surname' => $this->faker->word,
            'gender' => $this->faker->boolean,
            'birth' => $this->faker->date,
            'avatar' => null,
            'email' => $this->faker->unique()->safeEmail,
            PARAMS => [],
            'phone_number' => $this->faker->e164PhoneNumber,
            'password' => $password ?: $password = Hash::make('testing-password'),
            'phone_number_verified_at' => now(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_admin' => false
        ];
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function region(): UserFactory
    {
        return $this->state(function (array $attributes) {
            $country = Country::factory()->create();

            $region = Region::factory()->create([
                'country_id' => $country->id
            ]);

            return [
                'country_id' => $country->id,
                'region_id' => $region->id
            ];
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function unverified(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null
            ];
        });
    }
}
